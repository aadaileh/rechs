package com.sec.rechs.Services.HeartBeat.impl;


import com.sec.rechs.Model.Schedule;
import com.sec.rechs.Repository.ScheduleRepository;
import com.sec.rechs.Services.HeartBeat.SimpleExample;
import org.quartz.*;
import org.quartz.impl.StdSchedulerFactory;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.stereotype.Service;

import java.util.Date;
import java.util.List;
import java.util.Properties;

import static org.quartz.CronScheduleBuilder.cronSchedule;
import static org.quartz.JobBuilder.newJob;
import static org.quartz.TriggerBuilder.newTrigger;


/**
 * <h1>ApplianceController service implementations</h1>
 *
 * <p>
 * Contains the implementation of all members of the ApplianceController-Service
 * </p>
 *
 * @Author  Ahmed Al-Adaileh <k1530383@kingston.ac.uk> <ahmed.adaileh@gmail.com>
 * @version 1.0
 * @since   26.01.2018
 */
@Service
public class HeartBeatImplentations {

    private static final Logger LOG = LoggerFactory.getLogger(HeartBeatImplentations.class);

    ScheduleRepository scheduleRepository;

    public void run() throws Exception {
        Logger log = LoggerFactory.getLogger(SimpleExample.class);

        Properties prop = new Properties();

        //RMI configuration to make the client to connect to the Quartz server
        prop.put("org.quartz.scheduler.rmi.export", "true");
        prop.put("org.quartz.scheduler.rmi.createRegistry", "true");
        prop.put("org.quartz.scheduler.rmi.registryHost", "localhost");
        prop.put("org.quartz.scheduler.rmi.registryPort", "1099");
        prop.put("org.quartz.threadPool.class", "org.quartz.simpl.SimpleThreadPool");
        prop.put("org.quartz.threadPool.threadCount", "2");

        //Quartz Server Properties
        prop.put("quartz.scheduler.instanceName", "ServerScheduler");
        prop.put("org.quartz.scheduler.instanceId", "AUTO");
        prop.put("org.quartz.scheduler.skipUpdateCheck", "true");
        prop.put("org.quartz.scheduler.instanceId", "NON_CLUSTERED");
        prop.put("org.quartz.scheduler.jobFactory.class", "org.quartz.simpl.SimpleJobFactory");
        prop.put("org.quartz.jobStore.class", "org.quartz.impl.jdbcjobstore.JobStoreTX");
        prop.put("org.quartz.jobStore.driverDelegateClass", "org.quartz.impl.jdbcjobstore.StdJDBCDelegate");
        prop.put("org.quartz.jobStore.dataSource", "quartzDataSource");
        prop.put("org.quartz.jobStore.tablePrefix", "QRTZ_");
        prop.put("org.quartz.jobStore.isClustered", "false");

        //MYSQL DATABASE CONFIGURATION
        //If we do not specify this configuration, QUARTZ will use RAM(in-memory) to store jobs
        //Once we restart QUARTZ, the jobs will not be persisted
        prop.put("org.quartz.dataSource.quartzDataSource.driver", "com.mysql.jdbc.Driver");
        prop.put("org.quartz.dataSource.quartzDataSource.URL", "jdbc:mysql://localhost:3306/quartz");
        prop.put("org.quartz.dataSource.quartzDataSource.user", "root");
        prop.put("org.quartz.dataSource.quartzDataSource.password", "");
        prop.put("org.quartz.dataSource.quartzDataSource.maxConnections", "2");

        // First we must get a reference to a scheduler
        SchedulerFactory sf = new StdSchedulerFactory(prop);
        Scheduler scheduler = sf.getScheduler();

        JobDetail job = newJob(ScheduleExecuter.class)
                .withIdentity("schedule1", "schedule_management")
                .build();

        CronTrigger trigger = newTrigger()
                .withIdentity("trigger1", "schedule_management")
                .withSchedule(cronSchedule("0/20" + " * * * * ?"))
                .build();

        Date scheduleJob = scheduler.scheduleJob(job, trigger);
        log.info(job.getKey() + " has been scheduled to run at: " + scheduleJob + " and repeat based on expression: "
                + trigger.getCronExpression());


        List<Schedule> scheduleList = scheduleRepository.findAll();


        scheduler.start();


        SchedulerMetaData metaData = scheduler.getMetaData();
        log.info("Executed " + metaData.getNumberOfJobsExecuted() + " jobs.");

    }

    public ScheduleRepository getScheduleRepository() {
        return scheduleRepository;
    }

    public void setScheduleRepository(ScheduleRepository scheduleRepository) {
        this.scheduleRepository = scheduleRepository;
    }
}
