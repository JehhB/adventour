import cheerio from "cheerio";
import axios from "axios";
import fs from "fs";
import _ from "lodash";

const searchURL = "https://www.booking.com/searchresults.html";
const headers = {
  "User-Agent":
    "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36",
  "Accept-Encoding": "gzip, deflate, br",
  Accept: "*/*",
  Connection: "keep-alive",
  "Accept-Language": "en-US,en;q=0j.9,lt;q=0.8,et;q=0.7,de;q=0.6",
};

/**
 * @param {string} str
 * @param {number} start
 * @return {string}
 */
function getEnclosed(str, start = 0) {
  const length = str.length;

  const openSymbol = str.charAt(start);
  if ("[({".indexOf(openSymbol) === -1) return "";

  const chars = [openSymbol];
  const closeSymbol = {
    "[": "]",
    "(": ")",
    "{": "}",
  }[openSymbol];
  let tracker = 0;

  for (let i = start + 1; i < length; ++i) {
    const char = str.charAt(i);
    chars.push(char);

    if (char != openSymbol && char != closeSymbol) continue;

    if (char === openSymbol) {
      tracker++;
    } else if (tracker === 0) {
      break;
    } else {
      tracker--;
    }
  }

  return "".concat(...chars);
}

async function scrapeSearch(
  query = "Cagayan Valley, Philippines",
  checkin = null,
  checkout = null
) {
  const hotels = [];
  let totalResults = 0;
  let offset = 0;

  do {
    const searchParams = new URLSearchParams({
      ss: query,
      offset: offset,
      no_rooms: 1,
      group_adults: 1,
      group_children: 0,
    });
    if (checkin) searchParams.append("checkin", checkin);
    if (checkout) searchParams.append("checkout", checkout);

    const resp = await axios.get(`${searchURL}?${searchParams.toString()}`, {
      withCredentials: true,
      headers: headers,
    });
    const $ = cheerio.load(resp.data);
    console.log($("h1").text());
    totalResults = parseInt(
      $("h1")
        .text()
        .match(/(\d+) properties/)[1]
    );
    if (totalResults === 0) return [];

    $('[data-testid="property-card"]').each(function () {
      const $ = cheerio.load(this);
      const name = $('[data-testid="title"]').text();
      const url = $('[data-testid="title-link"]').attr("href");
      hotels.push({ name, url });
    });

    offset += 25;
  } while (offset < totalResults);

  return hotels;
}

async function scrapeHotel(url) {
  const resp = await axios.get(url, { headers });
  const html = resp.data;
  const $ = cheerio.load(html);

  const description = $(".hotel_description_review_display")
    .text()
    .replace(/You're eligible.*sign in\./gm, "")
    .replace(/The nearest airport.*\./, "")
    .trim();
  const address = $(".hp_address_subtitle").text().trim();
  const [lat, lng] = $("#hotel_address").attr("data-atlas-latlng").split(",");
  const [minLat, minLng, maxLat, maxLng] = $("#hotel_address")
    .attr("data-atlas-bbox")
    .split(",");

  const hotelPhotosIndex = html.indexOf("hotelPhotos");
  const hotelPhotos = eval(getEnclosed(html, hotelPhotosIndex + 13));
  const allImages = hotelPhotos.map((a) => a.large_url);

  const features = $('[data-testid="facility-list-most-popular-facilities"]')
    .first()
    .children()
    .map(function () {
      return $(this).text().trim();
    })
    .toArray();

  const rooms = await scrapeRooms(html, url);

  return {
    description,
    address,
    lat,
    lng,
    minLat,
    minLng,
    maxLat,
    maxLng,
    allImages,
    features,
    rooms,
  };
}

async function scrapeRooms(html, url) {
  const roomsMap = new Map();

  const rooms = JSON.parse(
    html.match(/b_rooms_available_and_soldout:\s*(.*),/)[1]
  ).map((room) => {
    const roomObj = {
      name: room.b_name,
      photos: [],
      highlights: [],
      offerings: _.uniqBy(
        room.b_blocks?.map((block) => ({
          maxPerson: block.b_max_persons,
          maxStay: block.b_nr_stays,
          mealPlan: block.b_mealplan_included_name ?? "none",
          price:
            block.b_price_breakdown_simplified.b_strikethrough_price_amount ===
            0
              ? block.b_price_breakdown_simplified.b_headline_price_amount
              : block.b_price_breakdown_simplified.b_strikethrough_price_amount,
          discountedPrice:
            block.b_price_breakdown_simplified.b_strikethrough_price_amount ===
            0
              ? 0
              : block.b_price_breakdown_simplified.b_headline_price_amount,
        })) ?? [],
        (offer) => `${offer.maxPerson}-${offer.maxStay}-${offer.mealPlan}`
      ),
    };
    roomsMap.set(room.b_id, roomObj);
    return roomObj;
  });

  const roomPhotosIndex = html.indexOf("allRoomPhotos");
  const roomPhotos = eval(getEnclosed(html, roomPhotosIndex + 15));
  roomPhotos?.forEach((photo) => {
    photo.associated_rooms?.forEach((room) => {
      const key = parseInt(room);
      if (roomsMap.has(key)) {
        roomsMap.get(key).photos.push(photo.large_url);
      }
    });
  });

  const resp = await axios.get(url, {
    headers: {
      ...headers,
      "User-Agent":
        "Mozilla/5.0 (Linux; Android 8.0; Pixel 2 Build/OPD3.170816.012) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Mobile Safari/537.36",
    },
  });
  const mobileHtml = resp.data;
  const highlightIndex = mobileHtml.indexOf("b_room_highlight");
  const highlights = JSON.parse(
    getEnclosed(mobileHtml, highlightIndex + 31).replace(/\\(.)/g, "$1")
  );

  for (const room in highlights) {
    const key = parseInt(room);
    if (roomsMap.has(key)) {
      const roomObj = roomsMap.get(key);
      highlights[room]?.forEach((highlight) => {
        if (highlight.type === "room_size") {
          roomObj.room_size = parseInt(highlight.name);
        } else {
          roomObj.highlights.push(highlight.name);
        }
      });
    }
  }

  return rooms;
}

async function main() {
  const hotels = await scrapeSearch(
    "Cagayan Valley, Philippines",
    "2023-07-04",
    "2023-07-05"
  );

  const output = [];
  for (const hotel of hotels) {
    try {
      console.log(hotel.name);
      const scrapedData = await scrapeHotel(hotel.url);
      const hotelData = {
        name: hotel.name,
        ...scrapedData,
      };
      output.push(hotelData);
    } catch (err) {
      console.log(err);
    }
  }
  fs.writeFileSync("output.json", JSON.stringify(output));
}

await main();
