TRUNCATE TABLE pong_data;
LOAD DATA INFILE '/var/www/html/Score_Data.csv' INTO TABLE pong_data fields TERMINATED BY ',' LINES TERMINATED BY '\n' IGNORE 1 ROWS;
