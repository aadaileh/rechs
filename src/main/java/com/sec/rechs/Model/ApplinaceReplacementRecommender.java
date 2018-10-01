package com.sec.rechs.Model;

import com.fasterxml.jackson.annotation.JsonIgnoreProperties;
import org.joda.time.DateTime;
import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.annotation.LastModifiedDate;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;
import java.io.Serializable;
import java.util.Date;

@Entity
@Table(name = "appliance_replacement_module")
@EntityListeners(AuditingEntityListener.class)
@JsonIgnoreProperties(value = {"createdTimestamp", "updatedTimestamp"},
        allowGetters = true)
public class ApplinaceReplacementRecommender implements Serializable {

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


    private String createdBy;
    private String runningMode;
    private Double runningIntervals;
    private boolean erros;
    private String errorsMessage;
    private DateTime nextRunningTime;

    private String applianceType;
    private int amountOfResults;
    private String status; //success/fail

    public String getApplianceType() {
        return applianceType;
    }

    public void setApplianceType(String applianceType) {
        this.applianceType = applianceType;
    }

    public int getAmountOfResults() {
        return amountOfResults;
    }

    public void setAmountOfResults(int amountOfResults) {
        this.amountOfResults = amountOfResults;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

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

    public String getCreatedBy() {
        return createdBy;
    }

    public void setCreatedBy(String createdBy) {
        this.createdBy = createdBy;
    }

    public String getRunningMode() {
        return runningMode;
    }

    public void setRunningMode(String runningMode) {
        this.runningMode = runningMode;
    }

    public Double getRunningIntervals() {
        return runningIntervals;
    }

    public void setRunningIntervals(Double runningIntervals) {
        this.runningIntervals = runningIntervals;
    }

    public boolean isErros() {
        return erros;
    }

    public void setErros(boolean erros) {
        this.erros = erros;
    }

    public String getErrorsMessage() {
        return errorsMessage;
    }

    public void setErrorsMessage(String errorsMessage) {
        this.errorsMessage = errorsMessage;
    }

    public DateTime getNextRunningTime() {
        return nextRunningTime;
    }

    public void setNextRunningTime(DateTime nextRunningTime) {
        this.nextRunningTime = nextRunningTime;
    }
}
