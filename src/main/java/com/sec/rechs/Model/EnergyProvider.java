package com.sec.rechs.Model;

import com.fasterxml.jackson.annotation.JsonIgnoreProperties;
import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.annotation.LastModifiedDate;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;
import java.io.Serializable;
import java.util.Date;

@Entity
@Table(name = "energy_provider")
@EntityListeners(AuditingEntityListener.class)
@JsonIgnoreProperties(value = {"createdTimestamp", "updatedTimestamp"},
        allowGetters = true)
public class EnergyProvider implements Serializable {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    private String name;
    private String contract_duration;
    private String contract_begin;
    private String contract_end;
    private String unit_price;
    private String total_annual_consumption;

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

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getContract_duration() {
        return contract_duration;
    }

    public void setContract_duration(String contract_duration) {
        this.contract_duration = contract_duration;
    }

    public String getContract_begin() {
        return contract_begin;
    }

    public void setContract_begin(String contract_begin) {
        this.contract_begin = contract_begin;
    }

    public String getContract_end() {
        return contract_end;
    }

    public void setContract_end(String contract_end) {
        this.contract_end = contract_end;
    }

    public String getUnit_price() {
        return unit_price;
    }

    public void setUnit_price(String unit_price) {
        this.unit_price = unit_price;
    }

    public String getTotal_annual_consumption() {
        return total_annual_consumption;
    }

    public void setTotal_annual_consumption(String total_annual_consumption) {
        this.total_annual_consumption = total_annual_consumption;
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
