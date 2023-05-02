LOAD DATA INFILE '/var/lib/mysql-files/hotels.csv'
INTO TABLE Hotels
FIELDS TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(@hotel_id, name, metaphone, description, address, average_price, @lat, @lng)
SET coordinate=ST_GeomFromText(
      CONCAT(
        'POINT(',
        FORMAT(@lat, 6),
        ' ',
        FORMAT(@lng, 6),
        ')'
      )
    );

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
(@room_id, hotel_id, room_type);

LOAD DATA INFILE '/var/lib/mysql-files/offerings.csv'
INTO TABLE Offerings
FIELDS TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(@offering_id, room_id, max_person, stays, price, orig_price, meal_plan);

