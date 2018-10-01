package com.sec.rechs.Repository;

import com.sec.rechs.DTOs.WattsAndDate;
import com.sec.rechs.Model.Measurment;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface MeasurmentRepository extends JpaRepository<Measurment, Long> {

    // Watts(hour)
    @Query("SELECT " +
            "CONCAT( HOUR(created_timestamp) ) as concatedDateTime, " +
            "ROUND(AVG(watts),4) as AVGMeasurment, " +
            "COUNT(*) as counter " +
            "FROM Measurment " +
            "WHERE appliance_id = :applianceId AND created_by = 'automatic'" +
            "GROUP BY " +
            "HOUR(created_timestamp)" +
            "ORDER BY created_timestamp")
    List<WattsAndDate> findWattsByApplianceIdGroupByHour(@Param("applianceId") Long ApplianceId);

    // Watts(year-month-day)
    @Query("SELECT " +
            "CONCAT( YEAR(created_timestamp), '-', MONTH(created_timestamp), '-', DAY(created_timestamp) ) as concatedDateTime, " +
            "ROUND(AVG(watts),4) as AVGMeasurment, " +
            "COUNT(*) as counter " +
            "FROM Measurment " +
            "WHERE appliance_id = :applianceId AND created_by = 'automatic'" +
            "GROUP BY " +
            "DAY(created_timestamp)," +
            "MONTH(created_timestamp)," +
            "YEAR(created_timestamp)" +
            "ORDER BY created_timestamp")
    List<WattsAndDate> findWattsByApplianceIdGroupByYearAndMonthAndDay(@Param("applianceId") Long ApplianceId);

    // Watts(month)
    @Query("SELECT " +
            "CONCAT( YEAR(created_timestamp), '-', MONTH(created_timestamp) ) as concatedDateTime, " +
            "ROUND(AVG(watts),4) as AVGMeasurment, " +
            "COUNT(*) as counter " +
            "FROM Measurment " +
            "WHERE appliance_id = :applianceId AND created_by = 'automatic'" +
            "GROUP BY " +
            "MONTH(created_timestamp), " +
            "YEAR(created_timestamp)" +
            "ORDER BY created_timestamp")
    List<WattsAndDate> findWattsByApplianceIdGroupByYearAndMonth(@Param("applianceId") Long ApplianceId);

    // Watts(year)
    @Query("SELECT " +
            "CONCAT( YEAR(created_timestamp) ) as concatedDateTime, " +
            "ROUND(AVG(watts),4) as AVGMeasurment, " +
            "COUNT(*) as counter " +
            "FROM Measurment " +
            "WHERE appliance_id = :applianceId AND created_by = 'automatic'" +
            "GROUP BY " +
            "YEAR(created_timestamp)" +
            "ORDER BY created_timestamp")
    List<WattsAndDate> findWattsByApplianceIdGroupByYear(@Param("applianceId") Long ApplianceId);

    // MIN(created_timestamp), MAX(created_timestamp)
    @Query("SELECT " +
            "   m, " +
            "   count(*) AS countedRecords, " +
            "   MIN(createdTimestamp) AS latest_created_timestamp, " +
            "   MAX(createdTimestamp) AS oldest_created_timestamp, " +
            "   AVG(watts) AS averageWatts, " +
            "   appliance " +
            "FROM Measurment m " +
            "WHERE m.createdBy = 'automatic' " +
            //"AND m.watts is not NULL " +
            "GROUP BY m.appliance")
    List<Measurment> findStatistics();
}