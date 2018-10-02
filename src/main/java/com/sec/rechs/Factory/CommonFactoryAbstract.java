package com.sec.rechs.Factory;


import com.sec.rechs.Client.FeignClient;
import feign.Feign;
import feign.gson.GsonDecoder;
import feign.gson.GsonEncoder;
import feign.okhttp.OkHttpClient;
import feign.slf4j.Slf4jLogger;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.stereotype.Component;

import javax.sql.DataSource;

/**
 * <h1>CommonFactoryAbstract Abstract Class</h1>
 *
 * <p>
 * Contains the necessary methods which are used in different places. It is introduced
 * in this application to increase the code-reusability and inheritance. It does demonstrate
 * the use of abstract classes
 * </p>
 *
 * @Author  Ahmed Al-Adaileh <k1530383@kingston.ac.uk> <ahmed.adaileh@gmail.com>
 * @version 1.0
 * @since   26.01.2018
 */
@Component
public abstract class CommonFactoryAbstract {

    protected static final Logger LOG = LoggerFactory.getLogger(CommonFactoryAbstract.class);

    @Value("${spring.feign.url}")
    private String feignUrl;

    @Autowired
    private DataSource dataSource;

    /**
     * Prepare Feign-client for communication with other services
     * @param path
     * @return FeignClient
     *
     *  @Author Ahmed Al-Adaileh <k1560383@kingston.ac.uk> <ahmed.adaileh@gmail.com>
     */
    protected FeignClient getFeignClient(String path) {

        FeignClient feignClient = Feign.builder()
                .client(new OkHttpClient())
                .encoder(new GsonEncoder())
                .decoder(new GsonDecoder())
                .logger(new Slf4jLogger(FeignClient.class))
                .logLevel(feign.Logger.Level.FULL)
                .target(FeignClient.class, "http://localhost:8282" + path);

        return feignClient;
    }
}
