package com.sec.rechs.Repository;

import com.sec.rechs.Model.Schedule;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface ScheduleRepository extends JpaRepository<Schedule, Long> {
    List<Schedule> findByApplianceId(@Param("applianceId") Long ApplianceId);


}