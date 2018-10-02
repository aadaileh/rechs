package com.sec.rechs.Services.Measurment;


import com.sec.rechs.DTOs.WattsAndDate;
import com.sec.rechs.Exception.ResourceNotFoundException;
import com.sec.rechs.Model.Measurment;
import com.sec.rechs.Repository.ApplianceRepository;
import com.sec.rechs.Repository.MeasurmentRepository;
import io.swagger.annotations.ApiOperation;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import javax.validation.Valid;
import java.util.List;

@RestController
@RequestMapping("/api/measurments")
public class MeasurmentController {

    @Autowired
    MeasurmentRepository measurmentRepository;

    @Autowired
    ApplianceRepository applianceRepository;

    // Get All Measurments
    @GetMapping("/")
    @ApiOperation("Retrieve all measurments for all appliances")
    public List<Measurment> getAllMeasurments() {
        return measurmentRepository.findAll();
    }

    // Create a new Measurment
    @PostMapping("/{applianceId}")
    @ApiOperation("Save a measurment")
    public Measurment createMeasurment(@PathVariable (value = "applianceId") Long applianceId,
                                 @Valid @RequestBody Measurment measurment) {
        return applianceRepository.findById(applianceId).map(appliance -> {
            measurment.setAppliance(appliance);
            return measurmentRepository.save(measurment);
        }).orElseThrow(() -> new ResourceNotFoundException("ApplianceController", "id", applianceId));
    }

    // Get a Single Measurment
    @GetMapping("/{id}")
    @ApiOperation("Retrieve a measurment by id")
    public Measurment getMeasurmentById(@PathVariable(value = "id") Long measurmentId) {
        return measurmentRepository.findById(measurmentId)
                .orElseThrow(() -> new ResourceNotFoundException("Measurment", "id", measurmentId));
    }

    // Get an Appliance Measurments (Watts)
    @GetMapping("/watts/appliance/{applianceId}/group-by/{groupBy}")
    @ApiOperation("Retrieve measurments (Watts) from an appliance by id")
    public List<WattsAndDate> getWattsByApplianceId(
            @PathVariable (value = "applianceId") Long applianceId,
            @PathVariable (value = "groupBy") String groupBy) {

        List<WattsAndDate> watts = null;

        if (groupBy.equals("hour")) {
            watts = measurmentRepository.findWattsByApplianceIdGroupByHour(applianceId);
        } else if (groupBy.equals("day")) {
            watts = measurmentRepository.findWattsByApplianceIdGroupByYearAndMonthAndDay(applianceId);
        } else if (groupBy.equals("month")) {
            watts = measurmentRepository.findWattsByApplianceIdGroupByYearAndMonth(applianceId);
        } else if (groupBy.equals("year")) {
            watts = measurmentRepository.findWattsByApplianceIdGroupByYear(applianceId);
        }

        return watts;
    }

    // Get lowest watts for an appliance
    @GetMapping("/watts/lowest")
    @ApiOperation("Retrieve lowest Watts measurments from all appliances")
    public List<Measurment> getLowestWatts() {
        List<Measurment> lowestWattsList = measurmentRepository.findLowestWatts();
        return lowestWattsList;
    }
    // Get Oldest and Latest Timestamp for all applinaces
    @GetMapping("/created-timestamp/latest-oldest")
    @ApiOperation("Retrieve latest and oldest created_timestamp from all appliances")
    public List<Measurment> getLatestAndOldestCreatedTimestamp() {
        List<Measurment> latestAndOldestCreatedTimestamp = measurmentRepository.findLatestAndOldestCreatedTimestamp();
        return latestAndOldestCreatedTimestamp;
    }

    /*
    * Following code should be adjusted if update-measurment and delete measurment are needed
    * */

//    @PutMapping("/posts/{postId}/comments/{commentId}")
//    public Comment updateComment(@PathVariable (value = "postId") Long postId,
//                                 @PathVariable (value = "commentId") Long commentId,
//                                 @Valid @RequestBody Comment commentRequest) {
//        if(!postRepository.existsById(postId)) {
//            throw new ResourceNotFoundException("PostId " + postId + " not found");
//        }
//
//        return commentRepository.findById(commentId).map(comment -> {
//            comment.setText(commentRequest.getText());
//            return commentRepository.save(comment);
//        }).orElseThrow(() -> new ResourceNotFoundException("CommentId " + commentId + "not found"));
//    }
//
//    @DeleteMapping("/posts/{postId}/comments/{commentId}")
//    public ResponseEntity<?> deleteComment(@PathVariable (value = "postId") Long postId,
//                                           @PathVariable (value = "commentId") Long commentId) {
//        if(!postRepository.existsById(postId)) {
//            throw new ResourceNotFoundException("PostId " + postId + " not found");
//        }
//
//        return commentRepository.findById(commentId).map(comment -> {
//            commentRepository.delete(comment);
//            return ResponseEntity.ok().build();
//        }).orElseThrow(() -> new ResourceNotFoundException("CommentId " + commentId + " not found"));
//    }
}
