package com.sec.rechs.Repository;

import com.sec.rechs.Model.EnergyProvider;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface EnergyProviderRepository extends JpaRepository<EnergyProvider, Long> {}