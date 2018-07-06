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
        LOG.info("Starting Local ZWAVE App");
        try {
            doZwaveStuff();
        } catch (HomeAutomationException e) {
            LOG.error("", e);
        }

        return "x";
    }

    /**
     * Initialises the binding. This is called after the 'updated' method
     * has been called and all configuration has been passed.
     */
    public void doZwaveStuff() throws HomeAutomationException {
        LOG.debug("Application startup");
        ZWaveSession s = new LocalZwaveSession();

        s.connect();

//        List<ZWaveNode> nodes1 = s.getDeviceManager().getNodes();


//        while(!s.isNetworkReady()) {
//            LOG.info("Network not ready yet, sleeping");
//            sleepUninterruptibly(1, TimeUnit.SECONDS);
//        }

        s.subscribe(new MyEventListener());

        final List<ZWaveNode> nodes = s.getDeviceManager().getNodes();

//        scheduledExecutorService.scheduleAtFixedRate(() ->
//                s.getDeviceManager().getNodes()
//                        .forEach(n -> LOG.info("Node found: {} status: {} availability: {} endpoints: {}", n.getNodeId(), n.getNodeStatus(),
//                                n.getAvailability(), n.getEndpoints()))
//                , 30, 60, SECONDS);


        s.schedule(new MeterGetAction(3, 6, Electric_WATT), SECONDS, 10);

        LOG.info("Network is ready, sending message");
        sleepUninterruptibly(5, SECONDS);

        s.doAction(new SwitchAction(3, SwitchAction.STATE.ON));


//        s.doAction(new GenerateCommandClassPollAction(3, 0, CommandClass.SWITCH_BINARY));
//        s.doAction(new GenerateCommandClassPollAction(3, 1, CommandClass.METER));
//
//        s.doAction(new MeterGetAction(3, 1, MeterScale.Electric_WATT));
//
//        s.doAction(new MultiInstanceEndpointAction(3));
//
//        s.doAction(new SwitchAction(3, SwitchAction.STATE.OFF));
//        s.doAction(new MeterGetAction(3, MeterScale.Electric_KWH));
//        s.doAction(new SwitchAction(3, 2, SwitchAction.STATE.OFF));
//        s.doAction(new SwitchAction(3, 3, SwitchAction.STATE.OFF));
//        s.doAction(new SwitchAction(3, 4, SwitchAction.STATE.OFF));
//        s.doAction(new SwitchAction(3, 5, SwitchAction.STATE.OFF));
//        s.doAction(new SwitchAction(3, SwitchAction.STATE.ON));
//        s.doAction(new SwitchAction(3, 6, SwitchAction.STATE.OFF));
//        s.doAction(new SwitchAction(3, 50));
//        s.doAction(new SwitchAction(3, 50));
//
//
//        s.doAction(new SwitchMultiLevelGetAction(3));
//
//        s.doAction(new RequestNodeInfoAction(3));
//
////        int nodeId = 13;
////        int dimmerLevel = 50;
////        s.doAction(new SwitchAction(() -> nodeId, SwitchAction.STATE.ON));
////        s.doAction(new SwitchAction(() -> 7, SwitchAction.STATE.ON));
////        s.doAction(new SwitchAction(() -> 7, dimmerLevel));
//
//        LOG.info("Waiting a bit to switch off so we can see some visual effect");
//        sleepUninterruptibly(10, SECONDS);
//
//        s.doAction(new SwitchAction(3, SwitchAction.STATE.OFF));
//        s.doAction(new SwitchAction(15, SwitchAction.STATE.OFF));
//        s.doAction(new SwitchAction(14, 6, SwitchAction.STATE.OFF));
//        s.doAction(new SwitchAction(14, 1, SwitchAction.STATE.ON));
//        s.doAction(new SwitchAction(14, 2, SwitchAction.STATE.ON));
//        s.doAction(new SwitchAction(14, 3, SwitchAction.STATE.ON));
//        s.doAction(new SwitchAction(14, 4, SwitchAction.STATE.ON));
//        s.doAction(new SwitchAction(14, 5, SwitchAction.STATE.ON));
//        s.doAction(new SwitchAction(14, 6, SwitchAction.STATE.ON));
//        s.doAction(new SwitchAction(7, 100));
//
//
//
////        s.doAction(new SwitchAction(() -> nodeId, SwitchAction.STATE.OFF));
////        s.doAction(new SwitchAction(() -> 7, 0));
////        s.doAction(new SwitchAction(() -> nodeId, SwitchAction.STATE.OFF));
////        s.doAction(new SwitchAction(() -> 7, SwitchAction.STATE.OFF));
//
//        LOG.info("Actions done");
//        sleepUninterruptibly(3, SECONDS);
//
//
    }

    public class MyEventListener implements EventHandler {

        @Autowired
        MeasurmentRepository measurmentRepository2;

        @Autowired
        ApplianceRepository applianceRepository2;

        @EventSubscribe
        public void receive(ZWaveEvent event) throws Exception {
            LOG.info("Received an event (customized): {}", event);

            BigDecimal value = ((MeterEvent) event).getValue();
            Measurment measurment = new Measurment();
            applianceRepository2.findById(3L).map(appliance -> {
                measurment.setAppliance(appliance);
                measurment.setKwh(123.1);
                return measurmentRepository2.save(measurment);
            }).orElseThrow(() -> new ResourceNotFoundException("Appliance", "id", 3));

            //return event.getValue();
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
