delete from rechs.users;
delete from rechs.appliances;
delete from rechs.measurments;


SET GLOBAL max_connections = 200000;

show status like '%connect%';



SELECT 
CONCAT( YEAR(created_timestamp), '-', MONTH(created_timestamp), '-', DAY(created_timestamp) ) as concatedDateTime, ROUND(AVG(watts),4) as AVGMeasurment, 
COUNT(*) as counter 
FROM rechs.measurments 
WHERE appliance_id = 3 
#AND watts != 0
GROUP BY 
DAY(created_timestamp),
MONTH(created_timestamp),
YEAR(created_timestamp);