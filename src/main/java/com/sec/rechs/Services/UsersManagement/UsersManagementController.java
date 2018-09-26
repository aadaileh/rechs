package com.sec.rechs.Services.UsersManagement;


import com.sec.rechs.Model.User;
import com.sec.rechs.Repository.ApplianceRepository;
import com.sec.rechs.Repository.UsersManagementRepository;
import io.swagger.annotations.ApiOperation;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import javax.validation.Valid;
import java.util.List;

@RestController
@RequestMapping("/api/users")
public class UsersManagementController {

    @Autowired
    UsersManagementRepository usersManagementRepository;

    @Autowired
    ApplianceRepository applianceRepository;

    // Get All Users
    @GetMapping("/")
    @ApiOperation("Retrieve all Users")
    public List<User> getAllUsers() {

        return usersManagementRepository.findAll();
    }

    // Create a new User
    @PostMapping("/")
    @ApiOperation("Save a user")
    public User createUser(@Valid @RequestBody User user) {
        return usersManagementRepository.save(user);
    }
}
