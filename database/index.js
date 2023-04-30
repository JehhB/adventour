import cheerio from "cheerio";
import axios from "axios";
import querystring from "querystring";
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

    const hotelData = $('[data-testid="property-card"]').each(function () {
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
  const csrfToken = html.match(/b_csrf_token:\s*'(.+?)'/)[1];
  const id = html.match(/b_hotel_id:\s*'(.+?)'/)[1];
  const cookie = resp.headers["set-cookie"]
    .map((c) => c.split(";")[0])
    .join(";");

  const description = $(".hotel_description_review_display").text().trim();
  const address = $(".hp_address_subtitle").text().trim();
  const [lat, lng] = $("#hotel_address").attr("data-atlas-latlng").split(",");
  const [minLat, minLng, maxLat, maxLng] = $("#hotel_address")
    .attr("data-atlas-bbox")
    .split(",");

  const allImages = [];
  for (const match of html.matchAll(/large_url:\s*'(.*?)'/g)) {
    allImages.push(match[1]);
  }

  const thumbImages = [];
  $(".bh-photo-grid-item > img").each(function () {
    thumbImages.push({
      src: $(this).attr("src"),
      alt: $(this).attr("alt"),
    });
  });

  const features = $('[data-testid="facility-list-most-popular-facilities"]')
    .first()
    .children()
    .map(function () {
      return $(this).text().trim();
    })
    .toArray();

  const price = await scrapePrices(id, csrfToken, cookie);
  const averagePrice = _.mean(price);

  const rooms = JSON.parse(
    html.match(/b_rooms_available_and_soldout:\s*(.*),/)[1]
  ).map((room) => ({
    name: room.b_name,
    offerings: _.uniqBy(
      room.b_blocks?.map((block) => ({
        maxPerson: block.b_max_persons,
        maxStay: block.b_nr_stays,
        mealPlan: block.b_mealplan_included_name ?? "none",
        price: block.b_price_breakdown_simplified.b_headline_price_amount,
        origPrice:
          block.b_price_breakdown_simplified.b_strikethrough_price_amount,
      })) ?? [],
      (offer) => `${offer.maxPerson}-${offer.maxStay}-${offer.mealPlan}`
    ),
  }));

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
    thumbImages,
    features,
    price,
    averagePrice,
    rooms,
  };
}

async function scrapePrices(id, csrfToken, cookie) {
  const data = {
    name: "hotel.availability_calendar",
    result_format: "price_histogram",
    hotel_id: id,
    search_config: JSON.stringify({
      b_adults_total: 1,
      b_nr_rooms_needed: 1,
      b_children_total: 0,
      b_children_ages_total: [],
      b_is_group_search: 0,
      b_pets_total: 0,
      b_rooms: [{ b_adults: 1, b_room_order: 1 }],
    }),
    checkin: new Date().toISOString().slice(0, 10),
    n_days: 30,
    respect_min_los_restriction: 1,
    los: 1,
  };
  const resp = await axios.post(
    "https://www.booking.com/fragment.json?cur_currency=php",
    querystring.stringify(data),
    {
      withCredentials: true,
      headers: {
        ...headers,
        "X-Booking-CSRF": csrfToken,
        Cookie: cookie,
        "Content-Type": "application/x-www-form-urlencoded",
      },
    }
  );
  return resp.data.data.days.map((day) => day.b_price);
}

const hotels = await scrapeSearch(
  "Cagayan Valley, Philippines",
  "2023-04-24",
  "2023-04-25"
);

const output = [];
for (const hotel of hotels) {
  console.log(hotel.name);
  const scrapedData = await scrapeHotel(hotel.url);
  const hotelData = {
    name: hotel.name,
    ...scrapedData,
  };
  output.push(hotelData);
}

fs.writeFileSync("output.json", JSON.stringify(output));
