package com.sec.rechs;


import com.sec.rechs.Exception.ResourceNotFoundException;
import com.sec.rechs.Model.Measurment;
import com.sec.rechs.Repository.ApplianceRepository;
import com.sec.rechs.Repository.MeasurmentRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Page;
import org.springframework.data.domain.Pageable;
import org.springframework.web.bind.annotation.*;

import javax.validation.Valid;
import java.util.List;

@RestController
@RequestMapping("/api")
public class MeasurmentController {

    @Autowired
    MeasurmentRepository measurmentRepository;

    @Autowired
    ApplianceRepository applianceRepository;

    // Get All Measurments
    @GetMapping("/measurments")
    public List<Measurment> getAllMeasurments() {
        return measurmentRepository.findAll();
    }

    // Create a new Measurment
    @PostMapping("/appliances/{applianceId}/measurments")
    public Measurment createMeasurment(@PathVariable (value = "applianceId") Long applianceId,
                                 @Valid @RequestBody Measurment measurment) {
        return applianceRepository.findById(applianceId).map(appliance -> {
            measurment.setAppliance(appliance);
            return measurmentRepository.save(measurment);
        }).orElseThrow(() -> new ResourceNotFoundException("Appliance", "id", applianceId));
    }

    // Get a Single Measurment
    @GetMapping("/measurments/{id}")
    public Measurment getMeasurmentById(@PathVariable(value = "id") Long measurmentId) {
        return measurmentRepository.findById(measurmentId)
                .orElseThrow(() -> new ResourceNotFoundException("Measurment", "id", measurmentId));
    }

    // Get an Appliance Measurments
    @GetMapping("/appliances/{applianceId}/measurments")
    public Page<Measurment> getAllMeasurmentsByApplianceId(@PathVariable (value = "applianceId") Long applianceId,
                                                           Pageable pageable) {
        return measurmentRepository.findByApplianceId(applianceId, pageable);
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
