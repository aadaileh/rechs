package com.sec.rechs.Services.HeartBeat;

import com.sec.rechs.Model.Schedule;
import com.sec.rechs.Repository.ScheduleRepository;
import com.sec.rechs.Services.HeartBeat.impl.HeartBeatImplentations;
import io.swagger.annotations.ApiOperation;
import org.slf4j.Logger;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.scheduling.annotation.Scheduled;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

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
 * @since   26.06.2018
 */
@RestController
@RequestMapping("/api/heart-beat")
public class HeartBeatController {

    private static final Logger LOG = getLogger(HeartBeatController.class);

    @Autowired
    ScheduleRepository scheduleRepository;

    HeartBeatImplentations heartBeatImplentations = new HeartBeatImplentations();

    // Run Heart Beat
    @Scheduled(fixedRate = 10000)
    @GetMapping("/schedules")
    @ApiOperation("Repeatedly check & run scheduled jobs")
    public void schedules() {

        heartBeatImplentations.setScheduleRepository(scheduleRepository);
        List<Schedule> scheduleList = scheduleRepository.findAll();
        List<Schedule> schedulesFiltered = heartBeatImplentations.getFilteredList(scheduleList);

        int x=0;
    }
}