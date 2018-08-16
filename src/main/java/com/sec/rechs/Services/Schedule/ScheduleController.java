package com.sec.rechs.Services.Schedule;


import com.sec.rechs.Exception.ResourceNotFoundException;
import com.sec.rechs.Model.Appliance;
import com.sec.rechs.Model.Schedule;
import com.sec.rechs.Repository.ApplianceRepository;
import com.sec.rechs.Repository.ScheduleRepository;
import io.swagger.annotations.ApiOperation;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/appliances")
public class ScheduleController {

    @Autowired
    ScheduleRepository scheduleRepository;

    @Autowired
    ApplianceRepository applianceRepository;

    // Create a new schedule
    @PostMapping("/{appliance-id}/schedule/add")
    @ApiOperation("Create new schedule for an appliance")
    public Schedule createSchedule(
            @PathVariable(value = "appliance-id") Long applianceId,
            @RequestBody Schedule schedule) {

        Appliance appliance = applianceRepository.findById(applianceId)
                .orElseThrow(() -> new ResourceNotFoundException("ApplianceController", "id", applianceId));

        schedule.setAppliance(appliance);
        schedule.setActive(true);
        return scheduleRepository.save(schedule);
    }

    // Get a list of available schedules for an appliance
    @GetMapping("/{appliance-id}/schedule/list")
    @ApiOperation("Get a list of available schedules for an appliance")
    public List<Schedule> getScheduleList(@PathVariable(value = "appliance-id") Long applianceId) {

        return scheduleRepository.findByApplianceId(applianceId);
    }

    // Activate a schedule based on the given schedule-Id
    @PutMapping("/schedule/{schedule-id}/activate")
    @ApiOperation("Activate a schedule based on the given schedule-Id")
    public void activateSchedule(@PathVariable(value = "schedule-id") Long scheduleId) {

        Schedule schedule = scheduleRepository.findById(scheduleId)
                .orElseThrow(() -> new ResourceNotFoundException("ApplianceController", "scheduleId", scheduleId));
        schedule.setActive(true);
        scheduleRepository.save(schedule);
    }

    // Deactivate a schedule based on the given schedule-Id
    @PutMapping("/schedule/{schedule-id}/deactivate")
    @ApiOperation("Deactivate a schedule based on the given schedule-Id")
    public void deactivateSchedule(@PathVariable(value = "schedule-id") Long scheduleId) {

        Schedule schedule = scheduleRepository.findById(scheduleId)
                .orElseThrow(() -> new ResourceNotFoundException("ApplianceController", "scheduleId", scheduleId));
        schedule.setActive(false);
        scheduleRepository.save(schedule);
    }

    // Delete a schedule based on the given schedule-Id
    @DeleteMapping("/schedule/{schedule-id}/delete")
    @ApiOperation("Delete a schedule based on the given schedule-Id")
    public void deleteSchedule(@PathVariable(value = "schedule-id") Long scheduleId) {

        scheduleRepository.deleteById(scheduleId);
    }
}
