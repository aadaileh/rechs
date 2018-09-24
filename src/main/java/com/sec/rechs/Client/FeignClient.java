package com.sec.rechs.Client;

import feign.Param;
import feign.RequestLine;

import java.util.List;

public interface FeignClient {

    @RequestLine("PATCH")
    void turnOn(@Param("id") int id);

    @RequestLine("PATCH")
    void turnOff(@Param("id") int id);

    @RequestLine("GET")
    List<Object> getLowestWatts();
}
