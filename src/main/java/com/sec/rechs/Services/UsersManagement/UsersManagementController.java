package com.sec.rechs.Services.UsersManagement;


import com.sec.rechs.Exception.ResourceNotFoundException;
import com.sec.rechs.Model.User;
import com.sec.rechs.Repository.ApplianceRepository;
import com.sec.rechs.Repository.AuthenticationRepository;
import com.sec.rechs.Repository.UsersManagementRepository;
import com.sec.rechs.Services.Authentication.impl.AuthenticationImplentations;
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

    @Autowired
    AuthenticationRepository authenticationRepository;

    AuthenticationImplentations authenticationImplentations = new AuthenticationImplentations();

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
        //encrypt plain password
        String encryptedPassword = authenticationImplentations.encrypt(user.getPassword());
        user.setPassword(encryptedPassword);
        return usersManagementRepository.save(user);
    }

    // Activate a user based on the given user-Id
    @PutMapping("/{user-id}/activate")
    @ApiOperation("Activate a user based on the given user-Id")
    public void activateUser(@PathVariable(value = "user-id") Long userId) {

        User user = usersManagementRepository.findById(userId)
                .orElseThrow(() -> new ResourceNotFoundException("UsersManagementController", "userId", userId));
        user.setActive(true);
        usersManagementRepository.save(user);
    }

    // Deactivate a user based on the given user-Id
    @PutMapping("/{user-id}/deactivate")
    @ApiOperation("Deactivate a user based on the given user-Id")
    public void deactivateUser(@PathVariable(value = "user-id") Long userId) {

        User user = usersManagementRepository.findById(userId)
                .orElseThrow(() -> new ResourceNotFoundException("UsersManagementController", "userId", userId));
        user.setActive(false);
        usersManagementRepository.save(user);
    }

    // Delete a user based on the given user-Id
    @DeleteMapping("/{user-id}")
    @ApiOperation("Delete a user based on the given user-Id")
    public void deleteUser(@PathVariable(value = "user-id") Long userId) {

        usersManagementRepository.deleteById(userId);
    }
}
