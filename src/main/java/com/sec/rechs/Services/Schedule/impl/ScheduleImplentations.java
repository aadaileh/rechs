package com.sec.rechs.Services.Schedule.impl;


import com.sec.rechs.Repository.ApplianceRepository;
import com.sec.rechs.Repository.MeasurmentRepository;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.stereotype.Service;


/**
 * <h1>Schedule service implementations</h1>
 *
 * <p>
 * Contains the implementation of all members of the ScheduleController-Service
 * </p>
 *
 * @Author  Ahmed Al-Adaileh <k1530383@kingston.ac.uk> <ahmed.adaileh@gmail.com>
 * @version 1.0
 * @since   26.01.2018
 */
@Service
public class ScheduleImplentations {

    private static final Logger LOG = LoggerFactory.getLogger(ScheduleImplentations.class);

    ApplianceRepository applianceRepository;
    MeasurmentRepository measurmentRepository;



    public void setApplianceRepository(ApplianceRepository applianceRepository) {
        this.applianceRepository = applianceRepository;
    }

    public void setMeasurmentRepository(MeasurmentRepository measurmentRepository) {
        this.measurmentRepository = measurmentRepository;
    }

}
