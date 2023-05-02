import _ from "lodash";
import axios from "axios";
import fs from "fs/promises";
import { metaphone } from "metaphone";

const hotels = JSON.parse(await fs.readFile("output.json"));

// For many to many relationship
const features = [];

let hotel_id = 1,
  image_id = 1,
  hotel_feature_id = 1,
  room_id = 1,
  offering_id = 1;

// Write Headers
await fs.writeFile(
  "hotels.csv",
  "hotel_id,name,metaphone,description,address,average_price,lat,lng\n"
);
//await fs.writeFile(
//  "images.csv",
//  "image_id,hotel_id,caption,content_type,base64\n"
//);
await fs.writeFile(
  "hotelFeatures.csv",
  "hotel_feature_id,hotel_id,feature_id\n"
);
await fs.writeFile("features.csv", "feature_id,feature\n");
await fs.writeFile("rooms.csv", "room_id,hotel_id,room_type\n");
await fs.writeFile(
  "offerings.csv",
  "offering_id,room_id,max_person,stays,price,orig_price,meal_plan\n"
);

async function handleHotel(hotel, hotel_id) {
  await fs.appendFile(
    "hotels.csv",
    `${hotel_id},"${hotel.name.replace('"', "'")}",${metaphone(
      hotel.name
    )},"${hotel.description.replace('"', "'")}","${hotel.address}",${
      hotel.averagePrice
    },${hotel.lat},${hotel.lng}\n`
  );

  for (const room of hotel.rooms) {
    await handleRoom(room, room_id++, hotel_id);
  }

  //for (const image of hotel.allImages) {
  //  await handleImage({ src: image, alt: "" }, image_id++, hotel_id);
  //}

  //for (const image of hotel.thumbImages) {
  //  await handleImage(image, image_id++, hotel_id);
  //}

  for (const feature of hotel.features) {
    await handleHotelFeature(feature, hotel_feature_id++, hotel_id);
  }
}

async function handleHotelFeature(feature, hotel_feature_id, hotel_id) {
  const featureIndex = features.indexOf(feature);
  const feature_id =
    featureIndex === -1 ? features.push(feature) : featureIndex + 1;
  await fs.appendFile(
    "hotelFeatures.csv",
    `${hotel_feature_id},${hotel_id},${feature_id}\n`
  );
}

async function handleImage(image, image_id, hotel_id) {
  console.log("getting image " + image_id);
  const resp = await axios.get(image.src, {
    responseType: "text",
    responseEncoding: "base64",
    headers: {
      "User-Agent":
        "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36",
      "Accept-Encoding": "gzip, deflate, br",
      Accept: "*/*",
      Connection: "keep-alive",
      "Accept-Language": "en-US,en;q=0j.9,lt;q=0.8,et;q=0.7,de;q=0.6",
    },
  });

  await fs.appendFile(
    "images.csv",
    `${image_id},${hotel_id},"${image.alt.replace(
      '"',
      "'"
    )}",${resp.headers.getContentType()},${resp.data}\n`
  );
}

async function handleRoom(room, room_id, hotel_id) {
  await fs.appendFile(
    "rooms.csv",
    `${room_id},${hotel_id},"${room.name.replace('"', "'")}"\n`
  );

  for (const offering of room.offerings) {
    await handleOffering(offering, offering_id++, room_id);
  }
}

async function handleOffering(offering, offering_id, room_id) {
  await fs.appendFile(
    "offerings.csv",
    `${offering_id},${room_id},${offering.maxPerson},${offering.maxStay},${offering.price},${offering.origPrice},${offering.mealPlan}\n`
  );
}

for (const hotel of hotels) {
  await handleHotel(hotel, hotel_id++);
}

for (let i = 0; i < features.length; ++i) {
  await fs.appendFile(
    "features.csv",
    `${i + 1},"${features[i].replace('"', "'")}"\n`
  );
}
