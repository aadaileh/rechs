package com.sec.rechs.DTOs;

import com.sec.rechs.Model.Appliance;

import java.util.Date;

/**
 * <h1>Data Transfer Object: Credentials</h1>
 *
 * <p>
 * Contains all related attributes and their getters and setters
 * </p>
 *
 * @Author  Ahmed Al-Adaileh <k1530383@kingston.ac.uk> <ahmed.adaileh@gmail.com>
 * @version 1.0
 * @since   26.01.2018
 */
public class Measurment {

    private Long id;
    private Appliance appliance;
    private Double watts;
    private Double amps;
    private Double volts;
    private Double kwh;
    private String createdBy;
    private Date createdTimestamp;
    private Date updatedTimestamp;

    public Long getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    public Appliance getAppliance() {
        return appliance;
    }

    public void setAppliance(Appliance appliance) {
        this.appliance = appliance;
    }

    public Double getWatts() {
        return watts;
    }

    public void setWatts(Double watts) {
        this.watts = watts;
    }

    public Double getAmps() {
        return amps;
    }

    public void setAmps(Double amps) {
        this.amps = amps;
    }

    public Double getVolts() {
        return volts;
    }

    public void setVolts(Double volts) {
        this.volts = volts;
    }

    public Double getKwh() {
        return kwh;
    }

    public void setKwh(Double kwh) {
        this.kwh = kwh;
    }

    public String getCreatedBy() {
        return createdBy;
    }

    public void setCreatedBy(String createdBy) {
        this.createdBy = createdBy;
    }

    public Date getCreatedTimestamp() {
        return createdTimestamp;
    }

    public void setCreatedTimestamp(Date createdTimestamp) {
        this.createdTimestamp = createdTimestamp;
    }

    public Date getUpdatedTimestamp() {
        return updatedTimestamp;
    }

    public void setUpdatedTimestamp(Date updatedTimestamp) {
        this.updatedTimestamp = updatedTimestamp;
    }
}
