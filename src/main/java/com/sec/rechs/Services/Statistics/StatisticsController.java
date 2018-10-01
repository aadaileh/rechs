package com.sec.rechs.Services.Statistics;

import com.sec.rechs.Model.ApplinaceReplacementRecommender;
import com.sec.rechs.Model.EnergyProviderOptimizer;
import com.sec.rechs.Model.Measurment;
import com.sec.rechs.Repository.ApplianceReplacementModuleRepository;
import com.sec.rechs.Repository.EnergySupplierModuleRepository;
import com.sec.rechs.Repository.MeasurmentRepository;
import com.sec.rechs.Services.Authentication.AuthenticationController;
import io.swagger.annotations.ApiOperation;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import javax.validation.Valid;
import java.util.List;

@RestController
@RequestMapping("/api/statistics/")
public class StatisticsController {

    private static final Logger LOG = LoggerFactory.getLogger(AuthenticationController.class);

    @Autowired
    MeasurmentRepository measurmentRepository;

    @Autowired
    ApplianceReplacementModuleRepository applianceReplacementModuleRepository;

    @Autowired
    EnergySupplierModuleRepository energySupplierModuleRepository;

    // Get some statistics related to the applinaces
    @GetMapping("/appliances")
    @ApiOperation("Retrieve statistics from all appliances")
    public List<Measurment> getStats() {

        List<Measurment> latestAndOldestCreatedTimestamp = measurmentRepository.findStatistics();
        return latestAndOldestCreatedTimestamp;
    }

    // Add new entry (statistics) related to the applinaces replacement
    @PostMapping("/appliance-replacement")
    @ApiOperation("Save stats related to the appliance replacement module")
    public ApplinaceReplacementRecommender saveStats(@Valid @RequestBody ApplinaceReplacementRecommender applinaceReplacementRecommender) {
        return applianceReplacementModuleRepository.save(applinaceReplacementRecommender);
    }

    // Get entries from ApplinaceReplacementRecommender
    @GetMapping("/appliance-replacement-recommender")
    @ApiOperation("Retrieve entries from ApplinaceReplacementRecommender")
    public List<ApplinaceReplacementRecommender> getApplinaceReplacementRecommender() {

        List<ApplinaceReplacementRecommender> all = applianceReplacementModuleRepository.findAll();
        return all;
    }

    // Add new entry (statistics) related to the energy supplier
    @PostMapping("/energy-supplier")
    @ApiOperation("Save stats related to the energy supplier module")
    public EnergyProviderOptimizer saveStatsEnergySupplier(@Valid @RequestBody EnergyProviderOptimizer energyProviderOptimizer) {
        return energySupplierModuleRepository.save(energyProviderOptimizer);
    }

    // Get entries from EnergyProviderOptimizer
    @GetMapping("/energy-supplier-optimizer")
    @ApiOperation("Retrieve entries from EnergyProviderOptimizer")
    public List<EnergyProviderOptimizer> getEnergySupplier() {

        List<EnergyProviderOptimizer> all = energySupplierModuleRepository.findAll();
        return all;
    }
}

