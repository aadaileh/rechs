package com.sec.rechs.Services.Authentication.impl;

import com.sec.rechs.DTOs.Credentials;
import com.sec.rechs.Model.User;
import com.sec.rechs.Repository.AuthenticationRepository;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.stereotype.Component;

import java.util.List;

/**
 * <h1>Authentication service implementations</h1>
 *
 * <p>
 * Contains the implementation of all members of the Authentication-Service
 * </p>
 *
 * @Author  Ahmed Al-Adaileh <k1530383@kingston.ac.uk> <ahmed.adaileh@gmail.com>
 * @version 1.0
 * @since   26.01.2018
 */
@Component
public class AuthenticationImplentations {

    private static final Logger LOG = LoggerFactory.getLogger(AuthenticationImplentations.class);

    AuthenticationRepository authenticationRepository;

    public User verifyCredentials(Credentials credentials) {
        User user = authenticationRepository.findByUsernameAndPassword(credentials.getUsername(), credentials.getPassword());
        return user;
    }

    public void setAuthenticationRepository(AuthenticationRepository authenticationRepository) {
        this.authenticationRepository = authenticationRepository;
    }
}
