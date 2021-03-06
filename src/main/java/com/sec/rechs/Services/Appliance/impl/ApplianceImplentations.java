package com.sec.rechs.Services.Appliance.impl;


import com.oberasoftware.home.zwave.api.ZWaveSession;
import com.oberasoftware.home.zwave.api.actions.SwitchAction;
import com.oberasoftware.home.zwave.exceptions.HomeAutomationException;
import com.oberasoftware.home.zwave.local.LocalZwaveSession;
import com.sec.rechs.Listener.RechsEventListener;
import com.sec.rechs.Repository.ApplianceRepository;
import com.sec.rechs.Repository.MeasurmentRepository;
import com.sec.rechs.Repository.StandbyDetectorAndOptimizerRepository;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.stereotype.Service;

import static com.google.common.util.concurrent.Uninterruptibles.sleepUninterruptibly;
import static java.util.concurrent.TimeUnit.SECONDS;


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
public class ApplianceImplentations {

    private static final Logger LOG = LoggerFactory.getLogger(ApplianceImplentations.class);

    ApplianceRepository applianceRepository;
    MeasurmentRepository measurmentRepository;
    StandbyDetectorAndOptimizerRepository standbyDetectorAndOptimizerRepository;

    public void recordNodeMeasurments(Long applianceId) {

        try {
            ZWaveSession zWaveSession = new LocalZwaveSession();
            zWaveSession.connect();

            RechsEventListener rechsEventListener = new RechsEventListener();
            rechsEventListener.setApplianceRepository(applianceRepository);
            rechsEventListener.setMeasurmentRepository(measurmentRepository);
            rechsEventListener.setStandbyDetectorAndOptimizerRepository(standbyDetectorAndOptimizerRepository);
            rechsEventListener.setApplianceId(applianceId);

            zWaveSession.subscribe(rechsEventListener);

            sleepUninterruptibly(10, SECONDS);

        } catch (HomeAutomationException e) {
            LOG.error("HomeAutomationException error::", e);
        }
    }

    public void turnOffNode(int nodeId) {
        try {
            ZWaveSession zWaveSession = new LocalZwaveSession();
            zWaveSession.connect();

            zWaveSession.doAction(new SwitchAction(nodeId, SwitchAction.STATE.OFF));

        } catch (HomeAutomationException e) {
            LOG.error("HomeAutomationException error::", e);
        }
    }

    public void turnOnNode(int nodeId) {
        try {
            ZWaveSession zWaveSession = new LocalZwaveSession();
            zWaveSession.connect();

            zWaveSession.doAction(new SwitchAction(nodeId, SwitchAction.STATE.ON));

        } catch (HomeAutomationException e) {
            LOG.error("HomeAutomationException error::", e);
        }
    }


    public void onOrOffNode(int nodeId) {
        try {
            ZWaveSession zWaveSession = new LocalZwaveSession();
            zWaveSession.connect();

//            zWaveSession.doAction(new SwitchAction(nodeId, SwitchAction.STATE.ON));
//
//            SwitchAction switchAction = new SwitchAction(3,0);
//            switchAction.getDesiredState();

            SwitchAction zWaveAction = new SwitchAction(nodeId, SwitchAction.STATE.OFF);
            int level = zWaveAction.getLevel();
            zWaveSession.doAction(zWaveAction);



            int x =0;

        } catch (HomeAutomationException e) {
            LOG.error("HomeAutomationException error::", e);
        }
    }

    public void setApplianceRepository(ApplianceRepository applianceRepository) {
        this.applianceRepository = applianceRepository;
    }

    public void setMeasurmentRepository(MeasurmentRepository measurmentRepository) {
        this.measurmentRepository = measurmentRepository;
    }

    public StandbyDetectorAndOptimizerRepository getStandbyDetectorAndOptimizerRepository() {
        return standbyDetectorAndOptimizerRepository;
    }

    public void setStandbyDetectorAndOptimizerRepository(StandbyDetectorAndOptimizerRepository standbyDetectorAndOptimizerRepository) {
        this.standbyDetectorAndOptimizerRepository = standbyDetectorAndOptimizerRepository;
    }
}
