package com.sec.rechs.Services.HeartBeat.impl;


import com.sec.rechs.Repository.SchedularRepository;
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
public class SchedularImplentations {

    private static final Logger LOG = LoggerFactory.getLogger(SchedularImplentations.class);

    SchedularRepository schedularRepository;

    public void setSchedularRepository(SchedularRepository schedularRepository) {
        this.schedularRepository = schedularRepository;
    }
}
