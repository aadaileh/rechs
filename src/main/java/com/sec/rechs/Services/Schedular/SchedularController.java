package com.sec.rechs.Services.Schedular;

import com.sec.rechs.Repository.SchedularRepository;
import com.sec.rechs.Services.Schedular.impl.SchedularImplentations;
import io.swagger.annotations.ApiOperation;
import org.slf4j.Logger;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

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
@RequestMapping("/api/schedular")
public class SchedularController {

    private static final Logger LOG = getLogger(SchedularController.class);

    @Autowired
    SchedularRepository schedularRepository;

    SchedularImplentations schedularImplentations = new SchedularImplentations();

    // Save schedular data to db
    @PutMapping("/{applianceId}/data")
    @ApiOperation("xxxx")
    public void saveSchedular() {
        schedularImplentations.setSchedularRepository(schedularRepository);
    }


}