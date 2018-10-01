package com.sec.rechs.Repository;

import com.sec.rechs.Model.EnergyProviderOptimizer;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface EnergySupplierModuleRepository extends JpaRepository<EnergyProviderOptimizer, Long> {}