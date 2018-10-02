package com.sec.rechs.DTOs;

import com.sec.rechs.Model.Appliance;

public class MeasurmentCustomized {

    private Measurment measurment;
    private Double watt;
    private Appliance appliance;

    public Measurment getMeasurment() {
        return measurment;
    }

    public void setMeasurment(Measurment measurment) {
        this.measurment = measurment;
    }

    public Double getWatt() {
        return watt;
    }

    public void setWatt(Double watt) {
        this.watt = watt;
    }

    public Appliance getAppliance() {
        return appliance;
    }

    public void setAppliance(Appliance appliance) {
        this.appliance = appliance;
    }
}
