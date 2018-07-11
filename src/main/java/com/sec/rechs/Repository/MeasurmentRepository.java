package com.sec.rechs.Repository;

import com.sec.rechs.Model.Measurment;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface MeasurmentRepository extends JpaRepository<Measurment, Long> {

    List<Measurment> findByApplianceIdAndAmpsIsNotNull(Long ApplianceId);

    List<Measurment> findByApplianceIdAndWattsIsNotNull(Long ApplianceId);

    List<Measurment> findByApplianceIdAndKwhIsNotNull(Long ApplianceId);

}