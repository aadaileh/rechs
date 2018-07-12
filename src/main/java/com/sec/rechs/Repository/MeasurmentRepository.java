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

    @Query("SELECT " +
            "CONCAT( YEAR(created_timestamp), '-', MONTH(created_timestamp), '-', DAY(created_timestamp)) as concatedDateTime, " +
            "AVG(amps) as AVGMeasurment, " +
            "COUNT(*) as counter " +
            "FROM Measurment " +
            "WHERE appliance_id = :applianceId " +
            "GROUP BY " +
            "DAY(created_timestamp)," +
            "MONTH(created_timestamp)," +
            "YEAR(created_timestamp)")
    List<AmpsAndDate> findByApplianceIdAndAmpsIsNotNull(@Param("applianceId") Long ApplianceId);

    @Query("SELECT " +
            "CONCAT( YEAR(created_timestamp), '-', MONTH(created_timestamp), '-', DAY(created_timestamp)) as concatedDateTime, " +
            "AVG(watts) as AVGMeasurment, " +
            "COUNT(*) as counter " +
            "FROM Measurment " +
            "WHERE appliance_id = :applianceId " +
            "GROUP BY " +
            "DAY(created_timestamp)," +
            "MONTH(created_timestamp)," +
            "YEAR(created_timestamp)")
    List<WattsAndDate> findByApplianceIdAndWattsIsNotNull(@Param("applianceId") Long ApplianceId);

    @Query("SELECT " +
            "CONCAT( YEAR(created_timestamp), '-', MONTH(created_timestamp), '-', DAY(created_timestamp)) as concatedDateTime, " +
            "AVG(kwh) as AVGMeasurment, " +
            "COUNT(*) as counter " +
            "FROM Measurment " +
            "WHERE appliance_id = :applianceId " +
            "GROUP BY " +
            "DAY(created_timestamp)," +
            "MONTH(created_timestamp)," +
            "YEAR(created_timestamp)")
    List<KwhAndDate> findByApplianceIdAndKwhIsNotNull(@Param("applianceId") Long ApplianceId);

}