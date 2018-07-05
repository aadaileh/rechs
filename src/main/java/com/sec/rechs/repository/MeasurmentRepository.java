package com.sec.rechs.repository;

import com.sec.rechs.model.Measurment;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface MeasurmentRepository extends JpaRepository<Measurment, Long> {

    Page<Measurment> findByApplianceId(Long ApplianceId, Pageable pageable);

}