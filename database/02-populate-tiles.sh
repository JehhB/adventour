#!/bin/sh

echo "Populating tiles started";
tail -n +2 /var/lib/mysql-files/tiles.csv | \
while IFS=',' read -r x y z image; do
  printf "Inserted tile ";
  mysql -h localhost -u "$MYSQL_USER" -D "$MYSQL_DATABASE" -p"$MYSQL_PASSWORD" -N 2> /dev/null << SQL
    INSERT INTO Tiles (x,y,z,image) VALUES ($x,$y,$z,FROM_BASE64('$image')); SELECT LAST_INSERT_ID() 
SQL
done;
echo "Populating tiles finished";
