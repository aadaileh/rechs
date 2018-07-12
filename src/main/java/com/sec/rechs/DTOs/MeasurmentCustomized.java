package com.sec.rechs.DTOs;

public class MeasurmentCustomized {

    private Long id;

    private String concatedDateTime;

    public MeasurmentCustomized(Number id, String title) {
        this.id = id.longValue();
        this.concatedDateTime = title;
    }

    public Long getId() {
        return id;
    }

    public String getConcatedDateTime() {
        return concatedDateTime;
    }
}
