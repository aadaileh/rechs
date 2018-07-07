package com.sec.rechs;


import com.oberasoftware.base.event.EventHandler;
import com.oberasoftware.base.event.EventSubscribe;
import com.oberasoftware.home.zwave.api.ZWaveSession;
import com.oberasoftware.home.zwave.api.actions.SwitchAction;
import com.oberasoftware.home.zwave.api.actions.devices.MeterGetAction;
import com.oberasoftware.home.zwave.api.events.ZWaveEvent;
import com.oberasoftware.home.zwave.api.events.devices.DeviceSensorEvent;
import com.oberasoftware.home.zwave.api.events.devices.MeterEvent;
import com.oberasoftware.home.zwave.api.events.devices.SwitchEvent;
import com.oberasoftware.home.zwave.api.events.devices.SwitchLevelEvent;
import com.oberasoftware.home.zwave.core.ZWaveNode;
import com.oberasoftware.home.zwave.exceptions.HomeAutomationException;
import com.oberasoftware.home.zwave.local.LocalZwaveSession;
import com.sec.rechs.exception.ResourceNotFoundException;
import com.sec.rechs.model.Appliance;
import com.sec.rechs.model.Measurment;
import com.sec.rechs.repository.ApplianceRepository;
import com.sec.rechs.repository.MeasurmentRepository;
import org.slf4j.Logger;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import javax.validation.Valid;
import java.math.BigDecimal;
import java.util.List;

import static com.google.common.util.concurrent.Uninterruptibles.sleepUninterruptibly;
import static com.oberasoftware.home.zwave.api.messages.types.MeterScale.Electric_WATT;
import static java.util.concurrent.TimeUnit.SECONDS;
import static org.slf4j.LoggerFactory.getLogger;

@RestController
@RequestMapping("/api")
public class ApplianceController {

    private static final Logger LOG = getLogger(ApplianceController.class);


    @Autowired
    MeasurmentRepository measurmentRepository;

    @Autowired
    ApplianceRepository applianceRepository;

    // Get data from node
    @GetMapping("/nodes/{nodeId}/data")
    public String getNodeData() {
        try {
            ZWaveSession s = new LocalZwaveSession();
            s.connect();

            MyEventListener myEventListener = new MyEventListener();
            myEventListener.setApplianceRepository(applianceRepository);
            myEventListener.setMeasurmentRepository(measurmentRepository);

            s.subscribe(myEventListener);
            final List<ZWaveNode> nodes = s.getDeviceManager().getNodes();
            s.schedule(new MeterGetAction(3, 6, Electric_WATT), SECONDS, 10);
            sleepUninterruptibly(5, SECONDS);

            s.doAction(new SwitchAction(3, SwitchAction.STATE.ON));

        } catch (HomeAutomationException e) {
            LOG.error("HomeAutomationException error::", e);
        }

        return "x";
    }

    public class MyEventListener implements EventHandler {

        MeasurmentRepository measurmentRepository = null;
        ApplianceRepository applianceRepository = null;

        Double kwh;
        Double amps;
        Double volts;
        Double watts;

        public MeasurmentRepository getMeasurmentRepository() {
            return measurmentRepository;
        }

        public void setMeasurmentRepository(MeasurmentRepository measurmentRepository) {
            this.measurmentRepository = measurmentRepository;
        }

        public ApplianceRepository getApplianceRepository() {
            return applianceRepository;
        }

        public void setApplianceRepository(ApplianceRepository applianceRepository) {
            this.applianceRepository = applianceRepository;
        }

        @EventSubscribe
        public void receive(ZWaveEvent event) throws Exception {


            LOG.info("Received an event (customized): {}", event);

            if(event instanceof MeterEvent) {

                BigDecimal value = ((MeterEvent) event).getValue();
                Measurment measurment = new Measurment();

                if(((MeterEvent) event).getScale().getLabel().equals("Energy")) {
                    this.kwh = ((MeterEvent) event).getValue().doubleValue();
                } else {
                    this.kwh = null;
                }

                if(((MeterEvent) event).getScale().getLabel().equals("Current")) {
                    this.amps = ((MeterEvent) event).getValue().doubleValue();
                } else {
                    this.amps = null;
                }

                if(((MeterEvent) event).getScale().getLabel().equals("Voltage")) {
                    this.volts = ((MeterEvent) event).getValue().doubleValue();
                } else {
                    this.volts = null;
                }

                if(((MeterEvent) event).getScale().getLabel().equals("Power")) {
                    this.watts = ((MeterEvent) event).getValue().doubleValue();
                } else {
                    this.watts = null;
                }

                measurment.setKwh(this.kwh);
                measurment.setCreatedBy("Abu Adaleh");
                measurment.setAmps(this.amps);
                measurment.setVolts(this.volts);
                measurment.setWatts(this.watts);

                applianceRepository.findById((long) 3).map(appliance -> {
                    measurment.setAppliance(appliance);
                    return measurmentRepository.save(measurment);
                }).orElseThrow(() -> new ResourceNotFoundException("Appliance", "id", 3));

                //return event.getValue();

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
    }


    // Get All Appliances
    @GetMapping("/appliances")
    public List<Appliance> getAllAppliances() {
        return applianceRepository.findAll();
    }

    // Create a new Appliance
    @PostMapping("/appliances")
    public Appliance createAppliance(@Valid @RequestBody Appliance appliance) {

        //HardwareManager hardwareManager = new HardwareManager();
        //ZWaveDriver zWaveDriver = new ZWaveDriver();

        return applianceRepository.save(appliance);
    }

    // Get a Single Appliance
    @GetMapping("/appliances/{id}")
    public Appliance getApplianceById(@PathVariable(value = "id") Long applianceId) {
        return applianceRepository.findById(applianceId)
                .orElseThrow(() -> new ResourceNotFoundException("Appliance", "id", applianceId));
    }

    // Update a Appliance
    @PutMapping("/appliances/{id}")
    public Appliance updateAppliance(@PathVariable(value = "id") Long applianceId,
                                @Valid @RequestBody Appliance applianceDetails) {

        Appliance appliance = applianceRepository.findById(applianceId)
                .orElseThrow(() -> new ResourceNotFoundException("Appliance", "id", applianceId));

        appliance.setSystemName(applianceDetails.getSystemName());
        appliance.setLabel(applianceDetails.getLabel());

        Appliance updatedAppliance = applianceRepository.save(appliance);
        return updatedAppliance;
    }

    // Delete a Appliance
    @DeleteMapping("/appliances/{id}")
    public ResponseEntity<?> deleteAppliance(@PathVariable(value = "id") Long applianceId) {
        Appliance appliance = applianceRepository.findById(applianceId)
                .orElseThrow(() -> new ResourceNotFoundException("Appliance", "id", applianceId));

        applianceRepository.delete(appliance);

        return ResponseEntity.ok().build();
    }
}
