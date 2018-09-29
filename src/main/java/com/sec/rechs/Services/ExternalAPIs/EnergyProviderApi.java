package com.sec.rechs.Services.ExternalAPIs;

import com.sec.rechs.DTOs.EnergyProviderInput;
import com.sec.rechs.Model.EnergyProvider;
import com.sec.rechs.Repository.EnergyProviderRepository;
import com.sec.rechs.Services.Authentication.AuthenticationController;
import io.swagger.annotations.ApiOperation;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.Optional;

@RestController
@RequestMapping("/api/energy-provider/")
public class EnergyProviderApi {

    private static final Logger LOG = LoggerFactory.getLogger(AuthenticationController.class);

    @Autowired
    EnergyProviderRepository energyProviderRepository;

    @GetMapping("/")
    @ApiOperation("Get current energy provider data")
    public EnergyProvider getCurrentEnergyProvider() {
        Optional<EnergyProvider> energyProviderOptional = energyProviderRepository.findById(1L);
        EnergyProvider energyProvider = energyProviderOptional.get();
        return energyProvider;
    }

    @GetMapping("/search")
    @ApiOperation("Search for new energy providers")
    public EnergyProvider searchEnergyProviders() {
        Optional<EnergyProvider> energyProviderOptional = energyProviderRepository.findById(1L);
        EnergyProvider energyProvider = energyProviderOptional.get();
        return energyProvider;
    }

    @PutMapping("/")
    @ApiOperation("Update current energy provider data")
    public EnergyProvider updateCurrentEnergyProvider(@RequestBody EnergyProviderInput energyProviderInput) {
        Optional<EnergyProvider> energyProviderOptional = energyProviderRepository.findById(1L);
        EnergyProvider energyProvider = energyProviderOptional.get();

        switch ( energyProviderInput.getName() ) {

            case "name":
                energyProvider.setName(energyProviderInput.getValue());
                break;

            case "contract_begin":
                energyProvider.setContract_begin(energyProviderInput.getValue());
                break;

            case "contract_end":
                energyProvider.setContract_end(energyProviderInput.getValue());
                break;

            case "unit_price":
                energyProvider.setUnit_price(energyProviderInput.getValue());
                break;

            case "total_annual_consumption":
                energyProvider.setTotal_annual_consumption(energyProviderInput.getValue());
                break;
        }

        energyProviderRepository.save(energyProvider);

        return energyProvider;
    }

}

