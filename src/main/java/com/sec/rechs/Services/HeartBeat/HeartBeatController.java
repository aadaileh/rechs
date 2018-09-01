package com.sec.rechs.Services.HeartBeat;

import com.sec.rechs.Model.Schedule;
import com.sec.rechs.Repository.ScheduleRepository;
import com.sec.rechs.Services.HeartBeat.impl.HeartBeatImplentations;
import org.slf4j.Logger;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.scheduling.annotation.Scheduled;
import org.springframework.web.bind.annotation.RestController;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;
import java.util.stream.Stream;

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
public class HeartBeatController {

    private static final Logger LOG = getLogger(HeartBeatController.class);

    @Autowired
    ScheduleRepository scheduleRepository;

    HeartBeatImplentations heartBeatImplentations = new HeartBeatImplentations();

    // Run Heart Beat
    @Scheduled(fixedRate = 9000)
    public void run() {

        heartBeatImplentations.setScheduleRepository(scheduleRepository);
        List<Schedule> scheduleList = scheduleRepository.findAll();
        List<Schedule> schedulesFiltered = new ArrayList<>();

        Stream<Schedule> scheduleStream = scheduleList.stream()
                .filter(s -> s.getActive().equals(Boolean.TRUE))
                .filter(s1 -> s1.getBegin().before(s1.getEnd()))
                .filter(s2 -> Arrays.asList(s2.getRepeat_every().split("-")).size() > 0)
                .filter(s3 -> !s3.getRepeat_every().isEmpty())
                .filter(s4 -> {
                    List<String> repeatEveryList = Arrays.asList(s4.getRepeat_every().split("-"));
                    boolean monday = repeatEveryList.contains("Monday");
                    boolean tuesday = repeatEveryList.contains("Tuesday");
                    boolean wednesday = repeatEveryList.contains("Wednesday");
                    boolean thursday = repeatEveryList.contains("Thursday");
                    boolean friday = repeatEveryList.contains("Friday");
                    boolean saturday = repeatEveryList.contains("Saturday");
                    boolean sunday = repeatEveryList.contains("Sunday");

                    return monday || tuesday || wednesday || thursday || friday || saturday || sunday;
                });

//                .map(s5 -> {
//                    schedulesFiltered.add(s5);
//                    return schedulesFiltered;
//                });
        //.forEach(item->heartBeatImplentations.out(item));

        int x = 0;
    }
}