package com.sec.rechs.Model;

import com.fasterxml.jackson.annotation.JsonIgnoreProperties;
import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.annotation.LastModifiedDate;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;
import java.io.Serializable;
import java.util.Date;

@Entity
@Table(name = "appliances")
@EntityListeners(AuditingEntityListener.class)
@JsonIgnoreProperties(value = {"createdTimestamp", "updatedTimestamp"},
        allowGetters = true)
public class Appliance implements Serializable {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    private String label;
    private Boolean status;
    private Long annualEnergyConsumption;
    private Long hourlyEnergyConsumption;
    private Long lowestEnergyConsumption;
    private int standbyDurationSpan; //Minutes entered by owner. Indicates the time should be considered before decide that appliance is in standby
    private String size;
    private String sizeUnit;
    private Boolean standByStatus;
    private String systemName;
    private String type;
    private String createdBy;
    private String energyEfficientClass;
    private String externalLink;

    @Column(nullable = false, updatable = false)
    @Temporal(TemporalType.TIMESTAMP)
    @CreatedDate
    private Date createdTimestamp;

    @Column(nullable = false)
    @Temporal(TemporalType.TIMESTAMP)
    @LastModifiedDate
    private Date updatedTimestamp;

    public Long getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    public String getLabel() {
        return label;
    }

    public void setLabel(String label) {
        this.label = label;
    }

    public String getSystemName() {
        return systemName;
    }

    public void setSystemName(String systemName) {
        this.systemName = systemName;
    }

    public String getType() {
        return type;
    }

    public void setType(String type) {
        this.type = type;
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

    public Boolean getStatus() {
        return status;
    }

    public void setStatus(Boolean status) {
        this.status = status;
    }

    public Long getAnnualEnergyConsumption() {
        return annualEnergyConsumption;
    }

    public void setAnnualEnergyConsumption(Long annualEnergyConsumption) {
        this.annualEnergyConsumption = annualEnergyConsumption;
    }

    public Long getHourlyEnergyConsumption() {
        return hourlyEnergyConsumption;
    }

    public void setHourlyEnergyConsumption(Long hourlyEnergyConsumption) {
        this.hourlyEnergyConsumption = hourlyEnergyConsumption;
    }

    public Long getLowestEnergyConsumption() {
        return lowestEnergyConsumption;
    }

    public void setLowestEnergyConsumption(Long lowestEnergyConsumption) {
        this.lowestEnergyConsumption = lowestEnergyConsumption;
    }

    public int getStandbyDurationSpan() {
        return standbyDurationSpan;
    }

    public void setStandbyDurationSpan(int standbyDurationSpan) {
        this.standbyDurationSpan = standbyDurationSpan;
    }

    public String getSize() {
        return size;
    }

    public void setSize(String size) {
        this.size = size;
    }

    public String getSizeUnit() {
        return sizeUnit;
    }

    public void setSizeUnit(String sizeUnit) {
        this.sizeUnit = sizeUnit;
    }

    public Boolean getStandByStatus() {
        return standByStatus;
    }

    public void setStandByStatus(Boolean standByStatus) {
        this.standByStatus = standByStatus;
    }

    public String getEnergyEfficientClass() {
        return energyEfficientClass;
    }

    public void setEnergyEfficientClass(String energyEfficientClass) {
        this.energyEfficientClass = energyEfficientClass;
    }

    public String getExternalLink() {
        return externalLink;
    }

    public void setExternalLink(String externalLink) {
        this.externalLink = externalLink;
    }
}