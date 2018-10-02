package com.sec.rechs.Model;

import com.fasterxml.jackson.annotation.JsonIgnoreProperties;
import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.annotation.LastModifiedDate;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;
import java.io.Serializable;
import java.util.Date;

@Entity
@Table(name = "standby_detector_module")
@EntityListeners(AuditingEntityListener.class)
@JsonIgnoreProperties(value = {"createdTimestamp", "updatedTimestamp"},
        allowGetters = true)
public class StandbyDetectorAndOptimizer implements Serializable {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @Column(nullable = false, updatable = false)
    @Temporal(TemporalType.TIMESTAMP)
    @CreatedDate
    private Date createdTimestamp;

    @Column(nullable = false)
    @Temporal(TemporalType.TIMESTAMP)
    @LastModifiedDate
    private Date updatedTimestamp;


    private String calculatedLowestEnergyLevel;
    private String applianceLowestEnergyLevel;
    private Long applianceId;
    private boolean active;

    public Long getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = id;
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

    public String getCalculatedLowestEnergyLevel() {
        return calculatedLowestEnergyLevel;
    }

    public void setCalculatedLowestEnergyLevel(String calculatedLowestEnergyLevel) {
        this.calculatedLowestEnergyLevel = calculatedLowestEnergyLevel;
    }

    public String getApplianceLowestEnergyLevel() {
        return applianceLowestEnergyLevel;
    }

    public void setApplianceLowestEnergyLevel(String applianceLowestEnergyLevel) {
        this.applianceLowestEnergyLevel = applianceLowestEnergyLevel;
    }

    public Long getApplianceId() {
        return applianceId;
    }

    public void setApplianceId(Long applianceId) {
        this.applianceId = applianceId;
    }

    public boolean isActive() {
        return active;
    }

    public void setActive(boolean active) {
        this.active = active;
    }
}
