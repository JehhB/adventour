CREATE TABLE Hotels (
  hotel_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  metaphone VARCHAR(255) NOT NULL,
  address VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  average_price FLOAT NOT NULL,
  coordinate POINT NOT NULL,

  INDEX (metaphone),
  SPATIAL INDEX (coordinate)
);

CREATE TABLE HotelImages (
  hotel_image_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  hotel_id INTEGER UNSIGNED NOT NULL,
  content_type VARCHAR(31) NOT NULL,
  caption TEXT NOT NULL,
  image MEDIUMBLOB NOT NULL,

  CONSTRAINT FOREIGN KEY (hotel_id) REFERENCES Hotels(hotel_id)
    ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Rooms (
  room_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  hotel_id INTEGER UNSIGNED NOT NULL,
  room_type VARCHAR(63) NOT NULL,

  CONSTRAINT FOREIGN KEY (hotel_id) REFERENCES Hotels(hotel_id)
    ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Offerings (
  offering_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  room_id INTEGER UNSIGNED NOT NULL,
  max_person INT UNSIGNED NOT NULL,
  stays INT UNSIGNED NOT NULL,
  price FLOAT NOT NULL,
  orig_price FLOAT NOT NULL,
  meal_plan ENUM('none', 'breakfast', 'all_inclusive') NOT NULL,

  CONSTRAINT FOREIGN KEY (room_id) REFERENCES Rooms(room_id)
    ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Features (
  feature_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  feature VARCHAR(127) UNIQUE
);

CREATE TABLE HotelFeatures (
  hotel_feature_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  hotel_id INTEGER UNSIGNED NOT NULL,
  feature_id INTEGER UNSIGNED NOT NULL,

  CONSTRAINT FOREIGN KEY (hotel_id) REFERENCES Hotels(hotel_id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FOREIGN KEY (feature_id) REFERENCES Features(feature_id)
    ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Tiles (
  tile_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  z INTEGER UNSIGNED NOT NULL,
  x INTEGER UNSIGNED NOT NULL,
  y INTEGER UNSIGNED NOT NULL,
  image BLOB NOT NULL
);
