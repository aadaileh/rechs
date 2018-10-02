package com.sec.rechs.Listener;

import com.oberasoftware.base.event.EventHandler;
import com.oberasoftware.base.event.EventSubscribe;
import com.oberasoftware.home.zwave.api.events.ZWaveEvent;
import com.oberasoftware.home.zwave.api.events.devices.DeviceSensorEvent;
import com.oberasoftware.home.zwave.api.events.devices.MeterEvent;
import com.oberasoftware.home.zwave.api.events.devices.SwitchEvent;
import com.oberasoftware.home.zwave.api.events.devices.SwitchLevelEvent;
import com.sec.rechs.Client.FeignClient;
import com.sec.rechs.Exception.ResourceNotFoundException;
import com.sec.rechs.Factory.CommonFactoryAbstract;
import com.sec.rechs.Model.Appliance;
import com.sec.rechs.Model.Measurment;
import com.sec.rechs.Model.StandbyDetectorAndOptimizer;
import com.sec.rechs.Repository.ApplianceRepository;
import com.sec.rechs.Repository.MeasurmentRepository;
import com.sec.rechs.Repository.StandbyDetectorAndOptimizerRepository;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.math.BigDecimal;
import java.util.Date;
import java.util.Optional;

@Service
public class RechsEventListener extends CommonFactoryAbstract implements EventHandler {

    private static final Logger LOG = LoggerFactory.getLogger(RechsEventListener.class);

    @Autowired
    MeasurmentRepository measurmentRepository;

    @Autowired
    ApplianceRepository applianceRepository;

    @Autowired
    StandbyDetectorAndOptimizerRepository standbyDetectorAndOptimizerRepository;

    Long applianceId;

    private static final int node = 3;

    @EventSubscribe
    public void receive(ZWaveEvent event) throws Exception {

        Double kwh;
        Double amps;
        Double volts;
        Double watts;

        if(event instanceof MeterEvent) {

            BigDecimal value = ((MeterEvent) event).getValue();
            Measurment measurment = new Measurment();

            if(((MeterEvent) event).getScale().getLabel().equals("Energy")) {
                kwh = ((MeterEvent) event).getValue().doubleValue();
            } else {
                kwh = null;
            }

            if(((MeterEvent) event).getScale().getLabel().equals("Current")) {
                amps = ((MeterEvent) event).getValue().doubleValue();
            } else {
                amps = null;
            }

            if(((MeterEvent) event).getScale().getLabel().equals("Voltage")) {
                volts = ((MeterEvent) event).getValue().doubleValue();
            } else {
                volts = null;
            }

            if(((MeterEvent) event).getScale().getLabel().equals("Power")) {
                watts = ((MeterEvent) event).getValue().doubleValue();
            } else {
                watts = null;
            }

            measurment.setKwh(kwh);
            measurment.setCreatedBy("automatic");
            measurment.setAmps(amps);
            measurment.setVolts(volts);
            measurment.setWatts(watts);

            Optional<Appliance> applianceById = applianceRepository.findById(applianceId);
            Appliance applianceForStandby = applianceById.get();
            if (applianceForStandby.getStandByStatus() == true && watts != null) {

                Double wattsInDouble = Double.valueOf(applianceForStandby.getLowestEnergyConsumption());
                Double calculatedWattsPlus = wattsInDouble + (wattsInDouble * 5)/100 ;
                Double calculatedWattsMinus = wattsInDouble - (wattsInDouble * 5)/100 ;

                if ( calculatedWattsPlus >= watts && watts >= calculatedWattsMinus){

                    StandbyDetectorAndOptimizer standbyDetectorAndOptimizer = standbyDetectorAndOptimizerRepository.findByApplianceIdAndActive(applianceId, true);
                    StandbyDetectorAndOptimizer savedEntry;
                    if (standbyDetectorAndOptimizer != null) {
                        //update
                        standbyDetectorAndOptimizer.setActive(true);
                        standbyDetectorAndOptimizer.setApplianceId(applianceId);
                        standbyDetectorAndOptimizer.setCalculatedLowestEnergyLevel("upper limit: " + String.valueOf(calculatedWattsPlus + ", lower limit:" + calculatedWattsMinus));
                        standbyDetectorAndOptimizer.setApplianceLowestEnergyLevel(String.valueOf(wattsInDouble));
                        standbyDetectorAndOptimizer.setUpdatedTimestamp(new Date());
                        savedEntry = standbyDetectorAndOptimizerRepository.save(standbyDetectorAndOptimizer);
                    } else {
                        //create new
                        StandbyDetectorAndOptimizer sdo = new StandbyDetectorAndOptimizer();
                        sdo.setActive(true);
                        sdo.setApplianceId(applianceId);
                        sdo.setCalculatedLowestEnergyLevel("upper limit: " + String.valueOf(calculatedWattsPlus + ", lower limit:" + calculatedWattsMinus));
                        sdo.setApplianceLowestEnergyLevel(String.valueOf(wattsInDouble));
                        sdo.setUpdatedTimestamp(new Date());
                        savedEntry = standbyDetectorAndOptimizerRepository.save(sdo);
                    }

                    long begin = savedEntry.getCreatedTimestamp().getTime();
                    long end = savedEntry.getUpdatedTimestamp().getTime();
                    long secondsBetweenBeginEnd = end - begin;
                    int standbyDurationSpan = applianceForStandby.getStandbyDurationSpan();
                    if ( secondsBetweenBeginEnd != 0 && secondsBetweenBeginEnd <= standbyDurationSpan) {
                        savedEntry.setActive(false);
                        standbyDetectorAndOptimizerRepository.save(savedEntry);

                        FeignClient feignClientOff = getFeignClient("/api/appliances/" + node + "/turnoff");
                        feignClientOff.turnOff(node);
                    }


                }

            }

                applianceRepository.findById(applianceId).map(appliance -> {
                    measurment.setAppliance(appliance);
                    return measurmentRepository.save(measurment);
                }).orElseThrow(() -> new ResourceNotFoundException("ApplianceController", "id", applianceId));

        }
    }

    @EventSubscribe
    public void handleSensorEvent(DeviceSensorEvent sensorEvent) {
        LOG.info("Received a sensor: {} value: {} for node: {}", sensorEvent.getSensorType(), sensorEvent.getValue().doubleValue(), sensorEvent.getNodeId());
    }

    @EventSubscribe
    public void handleSwitchLevelEvent(SwitchLevelEvent event) {

        LOG.info("Received a switch level: {}", event);
    }

    @EventSubscribe
    public void handleBinarySwitch(SwitchEvent event) {

        LOG.info("Received a switch event: {}", event);
    }

    public void setMeasurmentRepository(MeasurmentRepository measurmentRepository) {
        this.measurmentRepository = measurmentRepository;
    }

    public void setApplianceRepository(ApplianceRepository applianceRepository) {
        this.applianceRepository = applianceRepository;
    }

    public Long getApplianceId() {
        return applianceId;
    }

    public void setApplianceId(Long applianceId) {
        this.applianceId = applianceId;
    }

    public StandbyDetectorAndOptimizerRepository getStandbyDetectorAndOptimizerRepository() {
        return standbyDetectorAndOptimizerRepository;
    }

    public void setStandbyDetectorAndOptimizerRepository(StandbyDetectorAndOptimizerRepository standbyDetectorAndOptimizerRepository) {
        this.standbyDetectorAndOptimizerRepository = standbyDetectorAndOptimizerRepository;
    }
}