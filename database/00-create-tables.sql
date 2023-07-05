CREATE TABLE
  Users (
    user_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(320) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    account_type ENUM ('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
  );

CREATE TABLE
  Profiles (
    profile_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INTEGER UNSIGNED NOT NULL,
    username VARCHAR(127) NOT NULL,
    profile_pic VARCHAR(255) NULL DEFAULT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT FOREIGN KEY (user_id) REFERENCES Users (user_id) ON DELETE CASCADE ON UPDATE CASCADE
  );

CREATE TABLE
  Hotels (
    hotel_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    admin_id INTEGER UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    metaphone VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    coordinate POINT NOT NULL,

    INDEX (metaphone),
    SPATIAL INDEX (coordinate),
    CONSTRAINT FOREIGN KEY (admin_id) REFERENCES Users (user_id) ON DELETE CASCADE ON UPDATE CASCADE
  );

CREATE TABLE
  HotelImages (
    hotel_image_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    hotel_id INTEGER UNSIGNED NOT NULL,
    image VARCHAR(63) NOT NULL,
    CONSTRAINT FOREIGN KEY (hotel_id) REFERENCES Hotels (hotel_id) ON DELETE CASCADE ON UPDATE CASCADE
  );

CREATE TABLE
  Rooms (
    room_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    hotel_id INTEGER UNSIGNED NOT NULL,
    room_type VARCHAR(63) NOT NULL,
    room_size INTEGER UNSIGNED NOT NULL,
    CONSTRAINT FOREIGN KEY (hotel_id) REFERENCES Hotels (hotel_id) ON DELETE CASCADE ON UPDATE CASCADE
  );

CREATE TABLE
  RoomImages (
    room_image_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    room_id INTEGER UNSIGNED NOT NULL,
    image VARCHAR(63) NOT NULL,
    CONSTRAINT FOREIGN KEY (room_id) REFERENCES Rooms (room_id) ON DELETE CASCADE ON UPDATE CASCADE
  );

CREATE TABLE
  Highlights (
    highlight_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    highlight VARCHAR(127) UNIQUE
  );

CREATE TABLE
  RoomHighlights (
    room_highlight_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    room_id INTEGER UNSIGNED NOT NULL,
    highlight_id INTEGER UNSIGNED NOT NULL,
    CONSTRAINT FOREIGN KEY (room_id) REFERENCES Rooms (room_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (highlight_id) REFERENCES Highlights (highlight_id) ON DELETE CASCADE ON UPDATE CASCADE
  );

CREATE TABLE
  Offerings (
    offering_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    room_id INTEGER UNSIGNED NOT NULL,
    max_person INT UNSIGNED NOT NULL,
    stays INT UNSIGNED NOT NULL,
    price FLOAT NOT NULL,
    original_price FLOAT NOT NULL,
    meal_plan ENUM ('none', 'breakfast', 'all_inclusive') NOT NULL,
    CONSTRAINT FOREIGN KEY (room_id) REFERENCES Rooms (room_id) ON DELETE CASCADE ON UPDATE CASCADE
  );

CREATE TABLE
  Features (
    feature_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    feature VARCHAR(127) UNIQUE
  );

CREATE TABLE
  HotelFeatures (
    hotel_feature_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    hotel_id INTEGER UNSIGNED NOT NULL,
    feature_id INTEGER UNSIGNED NOT NULL,
    CONSTRAINT FOREIGN KEY (hotel_id) REFERENCES Hotels (hotel_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (feature_id) REFERENCES Features (feature_id) ON DELETE CASCADE ON UPDATE CASCADE
  );

CREATE TABLE
  Places (
    place_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    admin_id INTEGER UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    metaphone VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    open_time TIME NULL DEFAULT NULL,
    close_time TIME NULL DEFAULT NULL,
    coordinate POINT NOT NULL,

    INDEX (metaphone),
    SPATIAL INDEX (coordinate),
    CONSTRAINT FOREIGN KEY (admin_id) REFERENCES Users (user_id) ON DELETE CASCADE ON UPDATE CASCADE
  );

CREATE TABLE
  PlaceImages (
    place_image_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    place_id INTEGER UNSIGNED NOT NULL,
    image VARCHAR(63) NOT NULL,
    CONSTRAINT FOREIGN KEY (place_id) REFERENCES Places (place_id) ON DELETE CASCADE ON UPDATE CASCADE
  );

CREATE TABLE
  PlacesFeatures (
    places_feature_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    places_feature VARCHAR(127) UNIQUE
  );

CREATE TABLE
  PlacesFeaturesIM (
    places_features_im_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    place_id INTEGER UNSIGNED NOT NULL,
    places_feature_id INTEGER UNSIGNED NOT NULL,

    CONSTRAINT FOREIGN KEY (place_id) REFERENCES Places (place_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (places_feature_id) REFERENCES PlacesFeatures (places_feature_id) ON DELETE CASCADE ON UPDATE CASCADE
  );

CREATE TABLE
  Events (
    event_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    admin_id INTEGER UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    metaphone VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    coordinate POINT NOT NULL,

    INDEX (metaphone),
    SPATIAL INDEX (coordinate),
    CONSTRAINT FOREIGN KEY (admin_id) REFERENCES Users (user_id) ON DELETE CASCADE ON UPDATE CASCADE
  );

CREATE TABLE
  EventAttend (
    event_attend_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_id INTEGER UNSIGNED NOT NULL,
    user_id INTEGER UNSIGNED NOT NULL,
    set_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT FOREIGN KEY (event_id) REFERENCES Events (event_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (user_id) REFERENCES Users (user_id) ON DELETE CASCADE ON UPDATE CASCADE
  );

CREATE TABLE
  EventImages (
    event_image_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_id INTEGER UNSIGNED NOT NULL,
    image VARCHAR(63) NOT NULL,
    CONSTRAINT FOREIGN KEY (event_id) REFERENCES Events (event_id) ON DELETE CASCADE ON UPDATE CASCADE
  );

CREATE TABLE
  EventsFeatures (
    events_feature_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    events_feature VARCHAR(127) UNIQUE
  );

CREATE TABLE
  EventsFeaturesIM (
    events_features_im_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_id INTEGER UNSIGNED NOT NULL,
    events_feature_id INTEGER UNSIGNED NOT NULL,

    CONSTRAINT FOREIGN KEY (event_id) REFERENCES Events (event_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (events_feature_id) REFERENCES EventsFeatures (events_feature_id) ON DELETE CASCADE ON UPDATE CASCADE
  );


CREATE TABLE 
  Sessions (
    session_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    started_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  );

CREATE TABLE 
  HotelViews (
    hotel_view_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    session_id INTEGER UNSIGNED NOT NULL,
    hotel_id INTEGER UNSIGNED NOT NULL,
    viewed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT FOREIGN KEY (session_id) REFERENCES Sessions (session_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (hotel_id) REFERENCES Hotels (hotel_id) ON DELETE CASCADE ON UPDATE CASCADE
  );

CREATE TABLE
  HotelLikes (
    hotel_like_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INTEGER UNSIGNED NOT NULL,
    hotel_id INTEGER UNSIGNED NOT NULL,
    liked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT FOREIGN KEY (user_id) REFERENCES Users (user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (hotel_id) REFERENCES Hotels (hotel_id) ON DELETE CASCADE ON UPDATE CASCADE
  );

CREATE TABLE 
  EventViews (
    event_view_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    session_id INTEGER UNSIGNED NOT NULL,
    event_id INTEGER UNSIGNED NOT NULL,
    viewed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT FOREIGN KEY (session_id) REFERENCES Sessions (session_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (event_id) REFERENCES Events (event_id) ON DELETE CASCADE ON UPDATE CASCADE
  );

CREATE TABLE
  EventLikes (
    event_like_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INTEGER UNSIGNED NOT NULL,
    event_id INTEGER UNSIGNED NOT NULL,
    liked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT FOREIGN KEY (user_id) REFERENCES Users (user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (event_id) REFERENCES Events (event_id) ON DELETE CASCADE ON UPDATE CASCADE
  );

CREATE TABLE 
  PlaceViews (
    place_view_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    session_id INTEGER UNSIGNED NOT NULL,
    place_id INTEGER UNSIGNED NOT NULL,
    viewed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT FOREIGN KEY (session_id) REFERENCES Sessions (session_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (place_id) REFERENCES Places (place_id) ON DELETE CASCADE ON UPDATE CASCADE
  );

CREATE TABLE
  PlaceLikes (
    place_like_id INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INTEGER UNSIGNED NOT NULL,
    place_id INTEGER UNSIGNED NOT NULL,
    liked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT FOREIGN KEY (user_id) REFERENCES Users (user_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (place_id) REFERENCES Places (place_id) ON DELETE CASCADE ON UPDATE CASCADE
  );
