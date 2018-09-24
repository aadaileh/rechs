package com.sec.rechs.Services.HeartBeat;

import com.sec.rechs.Client.FeignClient;
import com.sec.rechs.Factory.CommonFactoryAbstract;
import com.sec.rechs.Model.Schedule;
import com.sec.rechs.Repository.ApplianceRepository;
import com.sec.rechs.Repository.ScheduleRepository;
import com.sec.rechs.Services.HeartBeat.impl.HeartBeatImplentations;
import io.swagger.annotations.ApiOperation;
import org.slf4j.Logger;
import org.springframework.beans.factory.annotation.Autowired;
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
public class HeartBeatController extends CommonFactoryAbstract {

    private static final Logger LOG = getLogger(HeartBeatController.class);

    @Autowired
    ScheduleRepository scheduleRepository;

    @Autowired
    ApplianceRepository applianceRepository;

    HeartBeatImplentations heartBeatImplentations = new HeartBeatImplentations();

    // Run Heart Beat
    //@Scheduled(fixedRate = 10000)
    @GetMapping("/schedules")
    @ApiOperation("Repeatedly check & run scheduled jobs")
    public void schedules() {

        heartBeatImplentations.setScheduleRepository(scheduleRepository);
        List<Schedule> scheduleList = scheduleRepository.findAll();
        List<Schedule> schedulesFiltered = heartBeatImplentations.getFilteredList(scheduleList);

        /*
        TODO:
        1. Loop through the schedulesFiltered list
        2. Switch it on/off
        3. Test if it works fine extensively!!
         */

        FeignClient feignClientOn = getFeignClient("/api/appliances/3/turnon");
        feignClientOn.turnOn(3);

//        FeignClient feignClientOff = getFeignClient("/api/appliances/3/turnoff");
//        feignClientOff.turnOff(3);

        int x=0;
    }
}