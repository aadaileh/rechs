package com.sec.rechs.Services.Authentication;


import com.sec.rechs.DTOs.Credentials;
import com.sec.rechs.Model.User;
import org.springframework.stereotype.Service;
import org.springframework.web.bind.annotation.RequestBody;

import java.sql.SQLException;

/**
 * <h1>Authentication Service Interface</h1>
 *
 * <p>
 * Main interface for the Authentication-Service. It describes and defines all needed
 * methods for the mentioned service.
 * </p>
 *
 * @Author  Ahmed Al-Adaileh <k1530383@kingston.ac.uk> <ahmed.adaileh@gmail.com>
 * @version 1.0
 * @since   26.01.2018
 */
@Service
//@EnableSwagger2
public interface AuthenticationInterface {

    /**
     * Method to verify the given credentials. Credentials can be either coming from ATM (card-id, pin) or
     * Online banking (username, password). This method makes a use of the login-service via Feign client.
     * It returns either the logged in user's data, in case of success. Or FALSE, in case of failure.
     *
     * @param credentials contains user's credentials
     * @return user user's data (if success), or null in case of failure
     *
     * @Author Ahmed Al-Adaileh <k1530383@kingston.ac.uk> <ahmed.adaileh@gmail.com>
     */
    public User verifyCredentials(@RequestBody Credentials credentials) throws SQLException;

//    /**
//     * Return the logged in user's data upon need. It returns either the requested user's data,
//     * in case it is found, Or empty object, in case of failure.
//     *
//     * @param username user's username
//     * @return user user's data (if success), or null in case of failure
//     *
//     * @Author Ahmed Al-Adaileh <k1530383@kingston.ac.uk> <ahmed.adaileh@gmail.com>
//     */
//    public User getUser(@RequestBody String username) throws SQLException;
}
