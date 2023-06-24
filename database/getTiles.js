import _ from "lodash";
import axios from "axios";
import sharp from "sharp";
import { existsSync, unlinkSync, readFileSync } from "fs";

// Taken from https://wiki.openstreetmap.org/wiki/Slippy_map_tilenames#ECMAScript_(JavaScript/ActionScript,_etc.)
function lonToX(lon, zoom) {
  return Math.floor(((lon + 180) / 360) * Math.pow(2, zoom));
}

function latToY(lat, zoom) {
  return Math.floor(
    ((1 -
      Math.log(
        Math.tan((lat * Math.PI) / 180) + 1 / Math.cos((lat * Math.PI) / 180)
      ) /
        Math.PI) /
      2) *
      Math.pow(2, zoom)
  );
}

function convertBbox(bbox, zoom) {
  const Y0 = latToY(bbox[0], zoom);
  const X0 = lonToX(bbox[1], zoom);
  const Y1 = latToY(bbox[2], zoom);
  const X1 = lonToX(bbox[3], zoom);

  return [
    Y0 < Y1 ? Y0 : Y1,
    X0 < X1 ? X0 : X1,
    Y0 < Y1 ? Y1 : Y0,
    X0 < X1 ? X1 : X0,
  ];
}

await fs.writeFile("tiles.csv", "x,y,z,images\n");

const data = JSON.parse(readFileSync("output.json"));
const bbox = [
  _.min(data.map((h) => h.minLat)),
  _.min(data.map((h) => h.minLng)),
  _.max(data.map((h) => h.maxLat)),
  _.max(data.map((h) => h.maxLng)),
].map((x) => parseFloat(x));

const [minY, minX, maxY, maxX] = convertBbox(bbox, 15);
console.log("count:", (4 / 3) * ((maxX - minX + 1) * (maxY - minY + 1)));

for (let z = 0; z <= 15; ++z) {
  const [minY, minX, maxY, maxX] = convertBbox(bbox, z);
  for (let x = minX; x <= maxX; ++x) {
    for (let y = minY; y <= maxY; ++y) {
      try {
        const resp = await axios.get(
          `https://tile.openstreetmap.org/${z}/${x}/${y}.png`,
          {
            responseType: "arraybuffer",
            headers: {
              "User-Agent":
                "Mozilla/5.0 (X11; Linux x86_64; rv:109.0) Gecko/20100101 Firefox/111.0",
              "Accept-Encoding": "gzip, deflate, br",
              Accept:
                "text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
              Connection: "keep-alive",
              "Accept-Language": "en-US,en;q=0.5",
            },
          }
        );
        console.log(
          `fetched: https://tile.openstreetmap.org/${z}/${x}/${y}.png`
        );

        const png = Buffer.from(resp.data);
        const webp = (
          await sharp(png).webp({ lossless: true }).toBuffer()
        ).toString("base64");

        await fs.appendFile("tiles.csv", `${x},${y},${z},${webp}\n`);

        await new Promise((r) => setTimeout(r, 100));
      } catch (e) {
        console.log(e);
      }
    }
  }
}
