package com.sec.rechs.Repository;

import com.sec.rechs.DTOs.AmpsAndDate;
import com.sec.rechs.DTOs.KwhAndDate;
import com.sec.rechs.DTOs.WattsAndDate;
import com.sec.rechs.Model.Measurment;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface MeasurmentRepository extends JpaRepository<Measurment, Long> {

    // Kwh(hour)
    @Query("SELECT " +
            "CONCAT( HOUR(created_timestamp) ) as concatedDateTime, " +
            "ROUND(AVG(kwh),4) as AVGMeasurment, " +
            "COUNT(*) as counter " +
            "FROM Measurment " +
            "WHERE appliance_id = :applianceId " +
            "GROUP BY " +
            "HOUR(created_timestamp)")
    List<KwhAndDate> findKwhByApplianceIdGroupByHour(@Param("applianceId") Long ApplianceId);
    // Kwh(year-month-day)
    @Query("SELECT " +
            "CONCAT( YEAR(created_timestamp), '-', MONTH(created_timestamp), '-', DAY(created_timestamp)) as concatedDateTime, " +
            "ROUND(AVG(kwh),4) as AVGMeasurment, " +
            "COUNT(*) as counter " +
            "FROM Measurment " +
            "WHERE appliance_id = :applianceId " +
            "GROUP BY " +
            "DAY(created_timestamp)," +
            "MONTH(created_timestamp)," +
            "YEAR(created_timestamp)")
    List<KwhAndDate> findKwhByApplianceIdGroupByYearAndMonthAndDay(@Param("applianceId") Long ApplianceId);
    // Kwh(year-week)
    @Query("SELECT " +
            "CONCAT( YEAR(created_timestamp), '-', WEEK(created_timestamp) ) as concatedDateTime, " +
            "ROUND(AVG(kwh),4) as AVGMeasurment, " +
            "COUNT(*) as counter " +
            "FROM Measurment " +
            "WHERE appliance_id = :applianceId " +
            "GROUP BY " +
            "WEEK(created_timestamp)," +
            "YEAR(created_timestamp)")
    List<KwhAndDate> findKwhByApplianceIdGroupByYearAndWeek(@Param("applianceId") Long ApplianceId);
    // Kwh(year-month)
    @Query("SELECT " +
            "CONCAT( YEAR(created_timestamp), '-', MONTH(created_timestamp) ) as concatedDateTime, " +
            "ROUND(AVG(kwh),4) as AVGMeasurment, " +
            "COUNT(*) as counter " +
            "FROM Measurment " +
            "WHERE appliance_id = :applianceId " +
            "GROUP BY " +
            "MONTH(created_timestamp)," +
            "YEAR(created_timestamp)")
    List<KwhAndDate> findKwhByApplianceIdGroupByYearAndMonth(@Param("applianceId") Long ApplianceId);
    // Kwh(year)
    @Query("SELECT " +
            "CONCAT( YEAR(created_timestamp) ) as concatedDateTime, " +
            "ROUND(AVG(kwh),4) as AVGMeasurment, " +
            "COUNT(*) as counter " +
            "FROM Measurment " +
            "WHERE appliance_id = :applianceId " +
            "GROUP BY " +
            "YEAR(created_timestamp)")
    List<KwhAndDate> findKwhByApplianceIdGroupByYear(@Param("applianceId") Long ApplianceId);


    // Watts(hour)
    @Query("SELECT " +
            "CONCAT( HOUR(created_timestamp) ) as concatedDateTime, " +
            "ROUND(AVG(watts),4) as AVGMeasurment, " +
            "COUNT(*) as counter " +
            "FROM Measurment " +
            "WHERE appliance_id = :applianceId " +
            "GROUP BY " +
            "HOUR(created_timestamp)")
    List<WattsAndDate> findWattsByApplianceIdGroupByHour(@Param("applianceId") Long ApplianceId);
    // Watts(year-month-day)
    @Query("SELECT " +
            "CONCAT( YEAR(created_timestamp), '-', MONTH(created_timestamp), '-', DAY(created_timestamp) ) as concatedDateTime, " +
            "ROUND(AVG(watts),4) as AVGMeasurment, " +
            "COUNT(*) as counter " +
            "FROM Measurment " +
            "WHERE appliance_id = :applianceId " +
            "GROUP BY " +
            "DAY(created_timestamp)," +
            "MONTH(created_timestamp)," +
            "YEAR(created_timestamp)")
    List<WattsAndDate> findWattsByApplianceIdGroupByYearAndMonthAndDay(@Param("applianceId") Long ApplianceId);
    // Watts(week)
    @Query("SELECT " +
            "CONCAT( YEAR(created_timestamp), '-', WEEK(created_timestamp) ) as concatedDateTime, " +
            "ROUND(AVG(watts),4) as AVGMeasurment, " +
            "COUNT(*) as counter " +
            "FROM Measurment " +
            "WHERE appliance_id = :applianceId " +
            "GROUP BY " +
            "WEEK(created_timestamp)," +
            "YEAR(created_timestamp)")
    List<WattsAndDate> findWattsByApplianceIdGroupByYearAndWeek(@Param("applianceId") Long ApplianceId);
    // Watts(month)
    @Query("SELECT " +
            "CONCAT( YEAR(created_timestamp), '-', MONTH(created_timestamp) ) as concatedDateTime, " +
            "ROUND(AVG(watts),4) as AVGMeasurment, " +
            "COUNT(*) as counter " +
            "FROM Measurment " +
            "WHERE appliance_id = :applianceId " +
            "GROUP BY " +
            "MONTH(created_timestamp), " +
            "YEAR(created_timestamp)")
    List<WattsAndDate> findWattsByApplianceIdGroupByYearAndMonth(@Param("applianceId") Long ApplianceId);
    // Watts(year)
    @Query("SELECT " +
            "CONCAT( YEAR(created_timestamp) ) as concatedDateTime, " +
            "ROUND(AVG(watts),4) as AVGMeasurment, " +
            "COUNT(*) as counter " +
            "FROM Measurment " +
            "WHERE appliance_id = :applianceId " +
            "GROUP BY " +
            "YEAR(created_timestamp)")
    List<WattsAndDate> findWattsByApplianceIdGroupByYear(@Param("applianceId") Long ApplianceId);
    // Amps(hour)
    @Query("SELECT " +
            "CONCAT( HOUR(created_timestamp) ) as concatedDateTime, " +
            "ROUND(AVG(amps),4) as AVGMeasurment, " +
            "COUNT(*) as counter " +
            "FROM Measurment " +
            "WHERE appliance_id = :applianceId " +
            "GROUP BY " +
            "HOUR(created_timestamp)")
    List<AmpsAndDate> findAmpsByApplianceIdGroupByHour(@Param("applianceId") Long ApplianceId);
    // Amps(year-month-day)
    @Query("SELECT " +
            "CONCAT( YEAR(created_timestamp), '-', MONTH(created_timestamp), '-', DAY(created_timestamp)) as concatedDateTime, " +
            "ROUND(AVG(amps),4) as AVGMeasurment, " +
            "COUNT(*) as counter " +
            "FROM Measurment " +
            "WHERE appliance_id = :applianceId " +
            "GROUP BY " +
            "DAY(created_timestamp)," +
            "MONTH(created_timestamp)," +
            "YEAR(created_timestamp)")
    List<AmpsAndDate> findAmpsByApplianceIdGroupByYearAndMonthAndDay(@Param("applianceId") Long ApplianceId);
}