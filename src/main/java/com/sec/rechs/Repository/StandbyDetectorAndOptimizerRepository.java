package com.sec.rechs.Repository;

import com.sec.rechs.Model.StandbyDetectorAndOptimizer;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface StandbyDetectorAndOptimizerRepository extends JpaRepository<StandbyDetectorAndOptimizer, Long> {
    StandbyDetectorAndOptimizer findByApplianceIdAndActive(Long applianceId, Boolean active);
}