package com.sec.rechs.Model;

import com.fasterxml.jackson.annotation.JsonIgnore;
import com.fasterxml.jackson.annotation.JsonIgnoreProperties;
import org.hibernate.annotations.OnDelete;
import org.hibernate.annotations.OnDeleteAction;
import org.joda.time.DateTime;
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

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "module_id", nullable = false)
    @OnDelete(action = OnDeleteAction.CASCADE)
    @JsonIgnore
    private ModulesManager modulesManager;

    @Column(nullable = false, updatable = false)
    @Temporal(TemporalType.TIMESTAMP)
    @CreatedDate
    private Date createdTimestamp;

    @Column(nullable = false)
    @Temporal(TemporalType.TIMESTAMP)
    @LastModifiedDate
    private Date updatedTimestamp;


    private String lowestEnergyLevel;
    private String runningMode;
    private Double runningIntervals;
    private boolean erros;
    private String errorsMessage;
    private DateTime nextRunningTime;

    public Long getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    public ModulesManager getModulesManager() {
        return modulesManager;
    }

    public void setModulesManager(ModulesManager modulesManager) {
        this.modulesManager = modulesManager;
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

    public String getLowestEnergyLevel() {
        return lowestEnergyLevel;
    }

    public void setLowestEnergyLevel(String lowestEnergyLevel) {
        this.lowestEnergyLevel = lowestEnergyLevel;
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
