package com.sec.rechs.Services.HeartBeat.impl;


import com.sec.rechs.Model.Schedule;
import com.sec.rechs.Repository.ScheduleRepository;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.stereotype.Service;

import java.time.LocalDate;
import java.util.Arrays;
import java.util.Date;
import java.util.List;
import java.util.stream.Collectors;


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

    public List<Schedule> getFilteredList(List<Schedule> scheduleList) {
        Date now = new Date();
        String today = LocalDate.now().getDayOfWeek().name().toLowerCase();
        return scheduleList.stream()
                .filter(s -> s.getActive().equals(Boolean.TRUE))
                .filter(s1 -> s1.getBegin().before(s1.getEnd()) && (now.before(s1.getEnd()) && now.after(s1.getBegin())))
                .filter(s2 -> Arrays.asList(s2.getRepeat_every().split("-", -1)).size() > 0)
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
                })
                .filter(s5->{
                    List<String> repeatEveryList = Arrays.asList(s5.getRepeat_every().split("-"));
                    repeatEveryList.replaceAll(String::toLowerCase);
                    boolean isToday = repeatEveryList.contains(today);
                    return isToday;
                })
                .collect(Collectors.toList());
    }

}
