package com.sec.rechs.Listener;

import com.oberasoftware.base.event.EventHandler;
import com.oberasoftware.base.event.EventSubscribe;
import com.oberasoftware.home.zwave.api.events.ZWaveEvent;
import com.oberasoftware.home.zwave.api.events.devices.DeviceSensorEvent;
import com.oberasoftware.home.zwave.api.events.devices.MeterEvent;
import com.oberasoftware.home.zwave.api.events.devices.SwitchEvent;
import com.oberasoftware.home.zwave.api.events.devices.SwitchLevelEvent;
import com.sec.rechs.Exception.ResourceNotFoundException;
import com.sec.rechs.Model.Measurment;
import com.sec.rechs.Repository.ApplianceRepository;
import com.sec.rechs.Repository.MeasurmentRepository;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.stereotype.Service;

import java.math.BigDecimal;

@Service
public class RechsEventListener implements EventHandler {

    private static final Logger LOG = LoggerFactory.getLogger(RechsEventListener.class);

    MeasurmentRepository measurmentRepository;
    ApplianceRepository applianceRepository;

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

            applianceRepository.findById((long) 1).map(appliance -> {
                measurment.setAppliance(appliance);
                return measurmentRepository.save(measurment);
            }).orElseThrow(() -> new ResourceNotFoundException("ApplianceController", "id", 1));

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
}

