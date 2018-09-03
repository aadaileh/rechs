package com.sec.rechs.Client;

import feign.Param;
import feign.RequestLine;

public interface FeignClient {

    @RequestLine("PATCH /{id}")
    void turnOn(@Param("id") int id);

    @RequestLine("PATCH /{id}")
    void turnOff(@Param("id") int id);

//    @RequestLine("GET")
//    List<BookResource> findAll();
//
//    @RequestLine("POST")
//    @Headers("Content-Type: application/json")
//    void create(Book book);

}
