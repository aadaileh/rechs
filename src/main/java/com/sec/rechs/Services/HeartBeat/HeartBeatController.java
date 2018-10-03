package com.sec.rechs.Services.HeartBeat;

import com.sec.rechs.Client.FeignClient;
import com.sec.rechs.Factory.CommonFactoryAbstract;
import com.sec.rechs.Model.Appliance;
import com.sec.rechs.Model.Schedule;
import com.sec.rechs.Repository.ApplianceRepository;
import com.sec.rechs.Repository.MeasurmentRepository;
import com.sec.rechs.Repository.ScheduleRepository;
import com.sec.rechs.Services.HeartBeat.impl.HeartBeatImplentations;
import io.swagger.annotations.ApiOperation;
import org.slf4j.Logger;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import java.util.List;
import java.util.Optional;

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
    private static final String lampLowestWatts = "0.577";
    private static final String tvLowestWatts = "1.46";
    private static final String frigLowestWatts = "0.502";
    private static final int node = 3;

    @Autowired
    ScheduleRepository scheduleRepository;

    @Autowired
    ApplianceRepository applianceRepository;

    @Autowired
    MeasurmentRepository measurmentRepository;

    HeartBeatImplentations heartBeatImplentations = new HeartBeatImplentations();

    // Run Heart Beat
    //@Scheduled(fixedDelay = 90000)
    @GetMapping("/schedules")
    @ApiOperation("Repeatedly check & run scheduled jobs")
    public void runSchedules() {

        heartBeatImplentations.setScheduleRepository(scheduleRepository);
        List<Schedule> scheduleList = scheduleRepository.findAll();
        List<Schedule> schedulesFiltered = heartBeatImplentations.getFilteredList(scheduleList);

        schedulesFiltered.forEach(item->{
            FeignClient feignClientOff = getFeignClient("/api/appliances/" + node + "/turnoff");
            feignClientOff.turnOff(node);
        });

    }

    //Get lowest consumed watts and write it to the appliance
    //@Scheduled(fixedDelay = 9000)
    @ApiOperation("Repeatedly get lowest consumed watts and write it to the appliance")
    public void getLowestWattAndWriteToAppliance() {

        //FeignClient feignClient = getFeignClient("/api/measurments/watts/lowest");
        //List<Object> lowestWatts = feignClient.getLowestWatts();

        Optional<Appliance> appliance = applianceRepository.findById(1L);
        Appliance lamp = appliance.get();
        lamp.setLowestEnergyConsumption(lampLowestWatts);
        applianceRepository.save(lamp);

        Optional<Appliance> appliance2 = applianceRepository.findById(2L);
        Appliance tv = appliance2.get();
        tv.setLowestEnergyConsumption(tvLowestWatts);
        applianceRepository.save(tv);

        Optional<Appliance> appliance3 = applianceRepository.findById(3L);
        Appliance frig = appliance.get();
        frig.setLowestEnergyConsumption(frigLowestWatts);
        applianceRepository.save(frig);

    }

    }