import _ from "lodash";
import fs from "fs/promises";
import { metaphone } from "metaphone";
import sha1 from "sha1";

const hotels = JSON.parse(await fs.readFile("output.json"));

// For many to many relationship
const features = [];
const highlights = [];

let hotel_id = 1,
  hotel_image_id = 1,
  hotel_feature_id = 1,
  room_id = 1,
  room_image_id = 1,
  room_highlight_id = 1,
  offering_id = 1;

// Write Headers
await fs.writeFile(
  "hotels.csv",
  "hotel_id,name,metaphone,description,address,lat,lng\n"
);
await fs.writeFile("hotelImages.csv", "hotel_image_id,hotel_id,ulid,url\n");
await fs.writeFile(
  "hotelFeatures.csv",
  "hotel_feature_id,hotel_id,feature_id\n"
);
await fs.writeFile("features.csv", "feature_id,feature\n");
await fs.writeFile("rooms.csv", "room_id,hotel_id,room_type,room_size\n");
await fs.writeFile(
  "roomHighlights.csv",
  "room_highlight_id,room_id,highlight_id\n"
);
await fs.writeFile("highlight.csv", "highlight_id,highlight\n");
await fs.writeFile("roomImages.csv", "room_image_id,room_id,ulid,url\n");
await fs.writeFile(
  "offerings.csv",
  "offering_id,room_id,max_person,stays,price,discounted_price,meal_plan\n"
);

async function handleHotel(hotel, hotel_id) {
  await fs.appendFile(
    "hotels.csv",
    `${hotel_id},"${hotel.name.replace('"', "'")}",${metaphone(
      hotel.name
    )},"${hotel.description.replace('"', "'")}","${hotel.address}",${
      hotel.lat
    },${hotel.lng}\n`
  );

  for (const room of hotel.rooms) {
    await handleRoom(room, room_id++, hotel_id);
  }

  for (const image of hotel.allImages) {
    await handleHotelImage(image, hotel_image_id++, hotel_id);
  }

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

async function handleHotelImage(image, hotel_image_id, hotel_id) {
  await fs.appendFile(
    "hotelImages.csv",
    `${hotel_image_id},${hotel_id},${sha1(image).toUpperCase()},${image}\n`
  );
}

async function handleRoom(room, room_id, hotel_id) {
  await fs.appendFile(
    "rooms.csv",
    `${room_id},${hotel_id},"${room.name.replace('"', "'")}",${
      room.room_size ?? 0
    }\n`
  );

  for (const image of room.photos) {
    await handleRoomImage(image, room_image_id++, room_id);
  }

  for (const offering of room.offerings) {
    await handleOffering(offering, offering_id++, room_id);
  }

  for (const highlight of room.highlights) {
    if (highlight === null) continue;
    await handleRoomHighlight(highlight, room_highlight_id++, room_id);
  }
}

async function handleRoomImage(image, room_image_id, room_id) {
  await fs.appendFile(
    "roomImages.csv",
    `${room_image_id},${room_id},${sha1(image).toUpperCase()},${image}\n`
  );
}

async function handleRoomHighlight(highlight, room_highlight_id, room_id) {
  const highlightIndex = highlights.indexOf(highlight);
  const highlightId =
    highlightIndex === -1 ? highlights.push(highlight) : highlightIndex + 1;
  await fs.appendFile(
    "roomHighlights.csv",
    `${room_highlight_id},${room_id},${highlightId}\n`
  );
}

async function handleOffering(offering, offering_id, room_id) {
  await fs.appendFile(
    "offerings.csv",
    `${offering_id},${room_id},${offering.maxPerson},${offering.maxStay},${offering.price},${offering.discountedPrice},${offering.mealPlan}\n`
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

for (let i = 0; i < highlights.length; ++i) {
  await fs.appendFile(
    "highlight.csv",
    `${i + 1},"${highlights[i].replace('"', "'")}"\n`
  );
}
