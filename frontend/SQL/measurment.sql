SELECT * from rechs.measurments order by id desc LIMIT 10000;

SELECT id, amps, created_timestamp from rechs.measurments where created_timestamp between '2018-07-22 00:00:00' AND '2018-07-22 23:59:59' order by amps desc LIMIT 1000000000;

SELECT id, watts from rechs.measurments where watts > 300 order by watts desc LIMIT 1000000000;

INSERT INTO `rechs`.`measurments` (`amps`, `created_by`, `created_timestamp`, `kwh`, `updated_timestamp`, `volts`, `watts`, `appliance_id`) 
VALUES ('3', 'manual', '2019-07-20 08:09:09', '30.819', '2019-07-20 08:09:09', '228.897', '0.9', '3');

SELECT id, appliance_id, kwh, DATE(`created_timestamp`), created_timestamp FROM rechs.measurments WHERE kwh IS NOT NULL LIMIT 100000;

SELECT 
    id, appliance_id, AVG(kwh), DATE(`created_timestamp`), created_timestamp
FROM
    rechs.measurments
WHERE
    kwh IS NOT NULL
GROUP BY DATE(`created_timestamp`) limit 1000000000000000000;

select HOUR('2018-07-07 12:33:37');

SELECT 
    CONCAT('CW: ', WEEK(created_timestamp)) AS concatedDateTime,
    WEEK(created_timestamp) AS dateDay,
    AVG(kwh) AS AVGKwh,
    COUNT(*) AS counter
FROM
    rechs.measurments
WHERE
    appliance_id = 3
GROUP BY WEEK(created_timestamp);


SELECT 
COUNT(*) as counter,
CONCAT( YEAR(created_timestamp), '-', MONTH(created_timestamp), '-', DAY(created_timestamp), ' ', HOUR(created_timestamp), ':', MINUTE(created_timestamp) ) as concatedDateTime, 
ROUND(AVG(watts),4) as AVGMeasurment
FROM rechs.measurments 
WHERE appliance_id = 2 
AND watts != 0
GROUP BY 
MINUTE(created_timestamp),
HOUR(created_timestamp),
DAY(created_timestamp),
MONTH(created_timestamp),
YEAR(created_timestamp);