package com.sec.rechs.Services.Appliance;

import com.google.common.base.Strings;
import com.sec.rechs.Exception.ResourceNotFoundException;
import com.sec.rechs.Model.Appliance;
import com.sec.rechs.Repository.ApplianceRepository;
import com.sec.rechs.Repository.MeasurmentRepository;
import com.sec.rechs.Repository.ScheduleRepository;
import com.sec.rechs.Services.Appliance.impl.ApplianceImplentations;
import io.swagger.annotations.ApiOperation;
import org.slf4j.Logger;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import javax.validation.Valid;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.List;
import java.util.Objects;

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
 * @since   26.06.2018
 */
@RestController
@RequestMapping("/api/appliances")
public class ApplianceController {

    private static final Logger LOG = getLogger(ApplianceController.class);

    @Autowired
    ApplianceRepository applianceRepository;

    @Autowired
    MeasurmentRepository measurmentRepository;

    @Autowired
    ScheduleRepository scheduleRepository;

    ApplianceImplentations applianceImplentations = new ApplianceImplentations();

    // Record data from node
    @GetMapping("/{applianceId}/record-data")
    @ApiOperation("Record the requested node's measurements")
    public String recordNodesMeasurments(@PathVariable(value = "applianceId") Long applianceId) {
        applianceImplentations.setApplianceRepository(applianceRepository);
        applianceImplentations.setMeasurmentRepository(measurmentRepository);
        applianceImplentations.recordNodeMeasurments(applianceId);

        return "Recording job started on: "
                + LocalDateTime.now()
                .format(DateTimeFormatter
                        .ofPattern("dd.MM.YYYY HH:mm:SS:SSS"))
                .toString();
    }

    // Get All appliances
    @GetMapping("/")
    @ApiOperation("Return a list of available nodes")
    public List<com.sec.rechs.Model.Appliance> getAllNodes() {
        return applianceRepository.findAll();
    }

    // Create a new appliance
    @PostMapping("/")
    @ApiOperation("Create new appliance")
    public com.sec.rechs.Model.Appliance createAppliance(@Valid @RequestBody Appliance appliance) {
        return applianceRepository.save(appliance);
    }

    // Get a single appliance
    @GetMapping("/{id}")
    @ApiOperation("Retrieve a single appliance by id")
    public com.sec.rechs.Model.Appliance getApplianceById(@PathVariable(value = "id") Long applianceId) {
        return applianceRepository.findById(applianceId)
                .orElseThrow(() -> new ResourceNotFoundException("ApplianceController", "id", applianceId));
    }

    // Update an appliance by Id
    @PutMapping("/{id}")
    @ApiOperation("Update appliance data by id")
    public com.sec.rechs.Model.Appliance updateAppliance(@PathVariable(value = "id") Long applianceId,
                                                         @Valid @RequestBody com.sec.rechs.Model.Appliance applianceDetails) {

        com.sec.rechs.Model.Appliance appliance = applianceRepository.findById(applianceId)
                .orElseThrow(() -> new ResourceNotFoundException("ApplianceController", "id", applianceId));

        if(!Strings.isNullOrEmpty(applianceDetails.getSystemName())) {
            appliance.setSystemName(applianceDetails.getSystemName());
        }

        if(!Strings.isNullOrEmpty(applianceDetails.getLabel())) {
            appliance.setLabel(applianceDetails.getLabel());
        }

        if(!Strings.isNullOrEmpty(applianceDetails.getCreatedBy())) {
            appliance.setCreatedBy(applianceDetails.getCreatedBy());
        }

        if(!Strings.isNullOrEmpty(applianceDetails.getEnergyEfficientClass())) {
            appliance.setEnergyEfficientClass(applianceDetails.getEnergyEfficientClass());
        }

        if(!Strings.isNullOrEmpty(applianceDetails.getExternalLink())) {
            appliance.setExternalLink(applianceDetails.getExternalLink());
        }

        if(!Strings.isNullOrEmpty(applianceDetails.getSize())) {
            appliance.setSize(applianceDetails.getSize());
        }

        if(!Strings.isNullOrEmpty(applianceDetails.getSizeUnit())) {
            appliance.setSizeUnit(applianceDetails.getSizeUnit());
        }

        if(!Strings.isNullOrEmpty(applianceDetails.getType())) {
            appliance.setType(applianceDetails.getType());
        }

        if(!Objects.isNull(applianceDetails.getAnnualEnergyConsumption())) {
            appliance.setAnnualEnergyConsumption(applianceDetails.getAnnualEnergyConsumption());
        }

        if(!Objects.isNull(applianceDetails.getHourlyEnergyConsumption())) {
            appliance.setHourlyEnergyConsumption(applianceDetails.getHourlyEnergyConsumption());
        }

        if(!Objects.isNull(applianceDetails.getLowestEnergyConsumption())) {
            appliance.setLowestEnergyConsumption(applianceDetails.getLowestEnergyConsumption());
        }

        if(!Objects.isNull(applianceDetails.getStandbyDurationSpan())) {
            appliance.setStandbyDurationSpan(applianceDetails.getStandbyDurationSpan());
        }

        if(applianceDetails.getStandByStatus() != null) {
            appliance.setStandByStatus(applianceDetails.getStandByStatus());
        }

        if(applianceDetails.getStatus() != null) {
            appliance.setStatus(applianceDetails.getStatus());
        }

        com.sec.rechs.Model.Appliance updatedAppliance = applianceRepository.save(appliance);
        return updatedAppliance;
    }

    // Delete an appliance by Id
    @DeleteMapping("/{id}")
    @ApiOperation("Delete an appliance by id")
    public ResponseEntity<?> deleteAppliance(@PathVariable(value = "id") Long applianceId) {
        com.sec.rechs.Model.Appliance appliance = applianceRepository.findById(applianceId)
                .orElseThrow(() -> new ResourceNotFoundException("ApplianceController", "id", applianceId));

        applianceRepository.delete(appliance);

        return ResponseEntity.ok().build();
    }

    // Turn off node by Id
    @PatchMapping("/{id}/turnoff")
    @ApiOperation("Turn a node OFF by its id")
    public void turnOffNode(@PathVariable(value = "id") int applianceId) {
        applianceImplentations.turnOffNode(applianceId);
    }

    //Turn on down node by Id
    @PatchMapping("/{id}/turnon")
    @ApiOperation("Turn a node ON by its id")
    public void turnOnNode(@PathVariable(value = "id") int applianceId) {
        applianceImplentations.turnOnNode(applianceId);
    }

    //Turn on down node by Id
    @PatchMapping("/{id}/on-or-off")
    @ApiOperation("Return appliance status: On/Off by id")
    public void onOrOffNode(@PathVariable(value = "id") int applianceId) {
        applianceImplentations.onOrOffNode(applianceId);
    }
}