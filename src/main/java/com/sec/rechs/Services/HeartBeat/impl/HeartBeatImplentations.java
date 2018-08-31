package com.sec.rechs.Services.HeartBeat.impl;


import com.sec.rechs.Model.Schedule;
import com.sec.rechs.Repository.ScheduleRepository;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.stereotype.Service;


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

    public boolean validateSchedule (Schedule schedule) {

        // 1. check if end-date before start-date
        if(schedule.getBegin().after(schedule.getEnd())) {
            return false;
        }

        // 2. check if the field repeat_every contains at least one day
        String repeatEvery = schedule.getRepeat_every();

        // 3. check if the schedule is active
        if (!schedule.getActive().equals(Boolean.TRUE)) {
            return false;
        }

        return true;
    }
}
