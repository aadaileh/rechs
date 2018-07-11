SELECT * from rechs.measurments order by id asc LIMIT 1000000000;

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
  CONCAT( HOUR(created_timestamp), ' to ', CONCAT( HOUR(created_timestamp), ':59:59' ) ) as time_frame, DATE(`created_timestamp`),AVG(kwh),
  COUNT(*) 
FROM 
  rechs.measurments
GROUP BY 
  DATE(created_timestamp), 
  HOUR(created_timestamp)