package com.sec.rechs.Services.HeartBeat.impl;


import com.sec.rechs.Model.Schedule;
import com.sec.rechs.Repository.ScheduleRepository;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.stereotype.Service;

import java.util.Arrays;
import java.util.List;


/**
 * <h1>ApplianceController service implementations</h1>
 *
 * <p>
 * Contains the implementation of all members of the ApplianceController-Service
 * </p>
 *
 * @Author  Ahmed Al-Adaileh <k1530383@kingston.ac.uk> <ahmed.adaileh@gmail.com>
 * @version 1.0
 * @since   26.01.2018
 */
@Service
public class HeartBeatImplentations {

    private static final Logger LOG = LoggerFactory.getLogger(HeartBeatImplentations.class);

    ScheduleRepository scheduleRepository;

    public ScheduleRepository getScheduleRepository() {
        return scheduleRepository;
    }

    public void setScheduleRepository(ScheduleRepository scheduleRepository) {
        this.scheduleRepository = scheduleRepository;
    }

    public void out (Schedule schedule) {

        // 2. check if the field repeat_every contains at least one day
        //String repeatEvery = schedule.getRepeat_every();
        //List<String> repeatEveryList = new ArrayList<String>(Arrays.asList(repeatEvery.split("-")));


        String[] split = "".split("-");

        Long id = schedule.getId();
        Boolean active = schedule.getActive();

        int x=0;
    }

    public boolean checkRepeatedDays (Schedule schedule) {

        List<String> repeatEveryList = Arrays.asList(schedule.getRepeat_every().split("-"));
        boolean b = repeatEveryList.containsAll(Arrays.asList("Monday", "Tuesday"));

        return true;
    }

}
