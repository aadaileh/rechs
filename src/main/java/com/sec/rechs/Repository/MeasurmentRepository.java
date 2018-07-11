package com.sec.rechs.Repository;

import com.sec.rechs.DTOs.AmpsAndDate;
import com.sec.rechs.DTOs.KwhAndDate;
import com.sec.rechs.Model.Measurment;
import com.sec.rechs.DTOs.WattsAndDate;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface MeasurmentRepository extends JpaRepository<Measurment, Long> {

    List<AmpsAndDate> findByApplianceIdAndAmpsIsNotNull(Long ApplianceId);

    List<WattsAndDate> findByApplianceIdAndWattsIsNotNull(Long ApplianceId);

    List<KwhAndDate> findByApplianceIdAndKwhIsNotNull(Long ApplianceId);

}