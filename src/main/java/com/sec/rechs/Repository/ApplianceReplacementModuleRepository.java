package com.sec.rechs.Repository;

import com.sec.rechs.Model.ApplinaceReplacementRecommender;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface ApplianceReplacementModuleRepository extends JpaRepository<ApplinaceReplacementRecommender, Long> {}