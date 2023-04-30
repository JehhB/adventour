#!/bin/sh

echo "Populating images started";
tail -n +2 /var/lib/mysql-files/images.csv | \
while IFS=',' read -r imageId hotelId caption contentType image; do
  mysql -h localhost -u "$MYSQL_USER" -D "$MYSQL_DATABASE" -p"$MYSQL_PASSWORD" 2> /dev/null << SQL
    INSERT INTO HotelImages (hotel_id,content_type,caption,image) 
    VALUES ($hotelId,'$contentType',$caption,FROM_BASE64('$image'));
SQL
  echo "Inserted image $imageId";
done;
echo "Populating images finished";
