LOAD DATA INFILE '/var/lib/mysql-files/hotels.csv'
INTO TABLE Hotels
FIELDS TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(@hotel_id, name, metaphone, description, address, @lat, @lng)
SET coordinate=ST_GeomFromText(
      CONCAT(
        'POINT(',
        FORMAT(@lat, 6),
        ' ',
        FORMAT(@lng, 6),
        ')'
      )
    );

LOAD DATA INFILE '/var/lib/mysql-files/hotelImages.csv'
INTO TABLE HotelImages
FIELDS TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(@hotel_image_id, hotel_id, @ulid, @url)
SET image=CONCAT(@ulid,'.jpg');

LOAD DATA INFILE '/var/lib/mysql-files/features.csv'
INTO TABLE Features
FIELDS TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(@feature_id, feature);

LOAD DATA INFILE '/var/lib/mysql-files/hotelFeatures.csv'
INTO TABLE HotelFeatures
FIELDS TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(@hotel_feature_id, hotel_id, feature_id);

LOAD DATA INFILE '/var/lib/mysql-files/rooms.csv'
INTO TABLE Rooms
FIELDS TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(@room_id, hotel_id, room_type, room_size);

LOAD DATA INFILE '/var/lib/mysql-files/roomImages.csv'
INTO TABLE RoomImages
FIELDS TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(@room_image_id, room_id, @ulid, @url)
SET image=CONCAT(@ulid,'.jpg');

LOAD DATA INFILE '/var/lib/mysql-files/highlight.csv'
INTO TABLE Highlights
FIELDS TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(@highlight_id, highlight);

LOAD DATA INFILE '/var/lib/mysql-files/roomHighlights.csv'
INTO TABLE RoomHighlights
FIELDS TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(@room_highlight_id, room_id, highlight_id);

LOAD DATA INFILE '/var/lib/mysql-files/offerings.csv'
INTO TABLE Offerings
FIELDS TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(@offering_id, room_id, max_person, stays, price, discounted_price, meal_plan);

