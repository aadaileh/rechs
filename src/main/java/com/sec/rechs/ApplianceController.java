package com.sec.rechs;


import com.sec.rechs.exception.ResourceNotFoundException;
import com.sec.rechs.model.Appliance;
import com.sec.rechs.repository.ApplianceRepository;
import com.sec.rechs.repository.MeasurmentRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import javax.validation.Valid;
import java.util.List;

@RestController
@RequestMapping("/api")
public class ApplianceController {

    @Autowired
    MeasurmentRepository measurmentRepository;

    @Autowired
    ApplianceRepository applianceRepository;

    // Get All Appliances
    @GetMapping("/appliances")
    public List<Appliance> getAllAppliances() {
        return applianceRepository.findAll();
    }

    // Create a new Appliance
    @PostMapping("/appliances")
    public Appliance createAppliance(@Valid @RequestBody Appliance appliance) {
        return applianceRepository.save(appliance);
    }

    // Get a Single Appliance
    @GetMapping("/appliances/{id}")
    public Appliance getApplianceById(@PathVariable(value = "id") Long applianceId) {
        return applianceRepository.findById(applianceId)
                .orElseThrow(() -> new ResourceNotFoundException("Appliance", "id", applianceId));
    }

    // Update a Appliance
    @PutMapping("/appliances/{id}")
    public Appliance updateAppliance(@PathVariable(value = "id") Long applianceId,
                                @Valid @RequestBody Appliance applianceDetails) {

        Appliance appliance = applianceRepository.findById(applianceId)
                .orElseThrow(() -> new ResourceNotFoundException("Appliance", "id", applianceId));

        appliance.setSystemName(applianceDetails.getSystemName());
        appliance.setLabel(applianceDetails.getLabel());

        Appliance updatedAppliance = applianceRepository.save(appliance);
        return updatedAppliance;
    }

    // Delete a Appliance
    @DeleteMapping("/appliances/{id}")
    public ResponseEntity<?> deleteAppliance(@PathVariable(value = "id") Long applianceId) {
        Appliance appliance = applianceRepository.findById(applianceId)
                .orElseThrow(() -> new ResourceNotFoundException("Appliance", "id", applianceId));

        applianceRepository.delete(appliance);

        return ResponseEntity.ok().build();
    }
}
