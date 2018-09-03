package com.sec.rechs.Client;

import feign.Param;
import feign.RequestLine;

public interface FeignClient {

    @RequestLine("PATCH")
    void turnOn(@Param("id") int id);

    @RequestLine("PATCH")
    void turnOff(int id);

}
