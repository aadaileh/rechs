package com.sec.rechs.Services.Authentication;

import com.sec.rechs.DTOs.Credentials;
import com.sec.rechs.Model.User;
import com.sec.rechs.Repository.AuthenticationRepository;
import com.sec.rechs.Services.Authentication.impl.AuthenticationImplentations;
import io.swagger.annotations.ApiOperation;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;


/**
 * <h1>Authentication Service</h1>
 *
 * <p>
 * Main Controller for the Authentication-Service. It implements all needed
 * methods for the mentioned service, to verify and authenticate requests and clients.
 * </p>
 *
 * @Author  Ahmed Al-Adaileh <k1530383@kingston.ac.uk> <ahmed.adaileh@gmail.com>
 * @version 1.0
 * @since   26.01.2018
 */
@RestController
@RequestMapping("/api/authentication")
public class AuthenticationController extends AuthenticationImplentations implements AuthenticationInterface {

    private static final Logger LOG = LoggerFactory.getLogger(AuthenticationController.class);

    @Autowired
    AuthenticationRepository authenticationRepository;

    AuthenticationImplentations authenticationImplentations = new AuthenticationImplentations();

    @PostMapping("/verify")
    @ApiOperation("Verify given username and password")
    public User verifyCredentials(@RequestBody Credentials credentials) {
        authenticationImplentations.setAuthenticationRepository(authenticationRepository);
        return authenticationImplentations.verifyCredentials(credentials);
    }
}