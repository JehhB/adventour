-- password is 'password'
INSERT INTO Users (user_id, email, password_hash, account_type)
VALUES (1, 'admin@adventour.local', '$2y$10$J7.N6jHMZo0aQbDYaGIOpudxk1ys.7MBjKxfajGcux3CjUnLI/2qC', 'admin');

INSERT INTO Profiles (user_id, username)
VALUES (1, 'Adventour Co.');

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
    ), admin_id=1;

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
(@offering_id, room_id, max_person, stays, price, original_price, meal_plan);

LOAD DATA INFILE '/var/lib/mysql-files/events.csv'
INTO TABLE Events
FIELDS TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(@event_id, name, address, @lat, @lng, start_date, end_date, description, metaphone)
SET coordinate=ST_GeomFromText(
      CONCAT(
        'POINT(',
        FORMAT(@lat, 6),
        ' ',
        FORMAT(@lng, 6),
        ')'
      )
    ), admin_id=1;

LOAD DATA INFILE '/var/lib/mysql-files/eventImages.csv'
INTO TABLE EventImages
FIELDS TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(event_id, image);

LOAD DATA INFILE '/var/lib/mysql-files/eventsFeature.csv'
INTO TABLE EventsFeatures
FIELDS TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(@events_feature_id, events_feature);

LOAD DATA INFILE '/var/lib/mysql-files/eventsFeatureIM.csv'
INTO TABLE EventsFeaturesIM
FIELDS TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(event_id, events_feature_id);

LOAD DATA INFILE '/var/lib/mysql-files/places.csv'
INTO TABLE Places
FIELDS TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(@place_id, name, address, @lat, @lng, open_time, close_time, description, metaphone)
SET coordinate=ST_GeomFromText(
      CONCAT(
        'POINT(',
        FORMAT(@lat, 6),
        ' ',
        FORMAT(@lng, 6),
        ')'
      )
    ), admin_id=1;

LOAD DATA INFILE '/var/lib/mysql-files/placeImages.csv'
INTO TABLE PlaceImages
FIELDS TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(place_id, image);

UPDATE Places
SET open_time = NULL, close_time = NULL
WHERE open_time = TIME '00:00';

LOAD DATA INFILE '/var/lib/mysql-files/placesFeature.csv'
INTO TABLE PlacesFeatures
FIELDS TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(@places_feature_id, places_feature);

LOAD DATA INFILE '/var/lib/mysql-files/placesFeatureIM.csv'
INTO TABLE PlacesFeaturesIM
FIELDS TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(place_id, places_feature_id);
