package com.sec.rechs.Services.Appliance;

import com.sec.rechs.Exception.ResourceNotFoundException;
import com.sec.rechs.Repository.ApplianceRepository;
import com.sec.rechs.Repository.MeasurmentRepository;
import com.sec.rechs.Services.Appliance.impl.ApplianceImplentations;
import io.swagger.annotations.ApiOperation;
import org.slf4j.Logger;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import javax.validation.Valid;
import java.util.List;

import static org.slf4j.LoggerFactory.getLogger;

/**
 * <h1>ApplianceController Service</h1>
 *
 * <p>
 * Main Controller for the ApplianceController-Service. It implements all needed
 * methods for the mentioned service including account's records, balance, and clients.
 * </p>
 *
 *
 * @Author  Ahmed Al-Adaileh <k1530383@kingston.ac.uk> <ahmed.adaileh@gmail.com>
 * @version 1.0
 * @since   26.01.2018
 */
@RestController
@RequestMapping("/api/appliances")
public class ApplianceController {

    private static final Logger LOG = getLogger(ApplianceController.class);

    @Autowired
    ApplianceRepository applianceRepository;

    @Autowired
    MeasurmentRepository measurmentRepository;

    ApplianceImplentations applianceImplentations = new ApplianceImplentations();

    // Get data from node
    @GetMapping("/{applianceId}/data")
    @ApiOperation("Retrieve and save Node's measurements")
    public void saveNodesMeasurments() {
        applianceImplentations.setApplianceRepository(applianceRepository);
        applianceImplentations.setMeasurmentRepository(measurmentRepository);
        applianceImplentations.saveNodeMeasurments();
    }

    // Get All Appliances
    @GetMapping("/")
    @ApiOperation("Return a list of available nodes")
    public List<com.sec.rechs.Model.Appliance> getAllNodes() {
        return applianceRepository.findAll();
    }

    // Create a new ApplianceController
    @PostMapping("/")
    @ApiOperation("Create new appliance")
    public com.sec.rechs.Model.Appliance createAppliance(@Valid @RequestBody com.sec.rechs.Model.Appliance appliance) {

        //HardwareManager hardwareManager = new HardwareManager();
        //ZWaveDriver zWaveDriver = new ZWaveDriver();

        return applianceRepository.save(appliance);
    }

    // Get a Single Appliance
    @GetMapping("/{id}")
    @ApiOperation("Retrieve a single appliance by id")
    public com.sec.rechs.Model.Appliance getApplianceById(@PathVariable(value = "id") Long applianceId) {
        return applianceRepository.findById(applianceId)
                .orElseThrow(() -> new ResourceNotFoundException("ApplianceController", "id", applianceId));
    }

    // Update a ApplianceController
    @PutMapping("/{id}")
    @ApiOperation("Update appliance data by id")
    public com.sec.rechs.Model.Appliance updateAppliance(@PathVariable(value = "id") Long applianceId,
                                                         @Valid @RequestBody com.sec.rechs.Model.Appliance applianceDetails) {

        com.sec.rechs.Model.Appliance appliance = applianceRepository.findById(applianceId)
                .orElseThrow(() -> new ResourceNotFoundException("ApplianceController", "id", applianceId));

        appliance.setSystemName(applianceDetails.getSystemName());
        appliance.setLabel(applianceDetails.getLabel());

        com.sec.rechs.Model.Appliance updatedAppliance = applianceRepository.save(appliance);
        return updatedAppliance;
    }

    // Delete a ApplianceController
    @DeleteMapping("/{id}")
    @ApiOperation("Delete an appliance by id")
    public ResponseEntity<?> deleteAppliance(@PathVariable(value = "id") Long applianceId) {
        com.sec.rechs.Model.Appliance appliance = applianceRepository.findById(applianceId)
                .orElseThrow(() -> new ResourceNotFoundException("ApplianceController", "id", applianceId));

        applianceRepository.delete(appliance);

        return ResponseEntity.ok().build();
    }
}
