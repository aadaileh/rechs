package com.sec.rechs.Services.HeartBeat.impl;

/*
 * All content copyright Terracotta, Inc., unless otherwise indicated. All rights reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy
 * of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 *
 */

import com.sec.rechs.Model.Schedule;
import com.sec.rechs.Repository.ScheduleRepository;
import org.quartz.Job;
import org.quartz.JobExecutionContext;
import org.quartz.JobExecutionException;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;

import java.util.List;

/**
 * <p>
 * This is just a simple job that gets fired off many times by example 1
 * </p>
 *
 * @author Bill Kratzer
 */
public class ScheduleExecuter implements Job {

    private static Logger LOG = LoggerFactory.getLogger(ScheduleExecuter.class);

    @Autowired
    ScheduleRepository scheduleRepository;

    HeartBeatImplentations heartBeatImplentations = new HeartBeatImplentations();

    /**
     * Quartz requires a public empty constructor so that the
     * scheduler can instantiate the class whenever it needs.
     */
    public ScheduleExecuter() {}

    /**
     * <p>
     * Called by the <code>{@link org.quartz.Scheduler}</code> when a
     * <code>{@link org.quartz.Trigger}</code> fires that is associated with
     * the <code>Job</code>.
     * </p>
     *
     * @throws JobExecutionException
     *             if there is an exception while executing the job.
     */
    public void execute(JobExecutionContext context)
            throws JobExecutionException {

        //JobKey jobKey = context.getJobDetail().getKey();
        //LOG.info("ScheduleExecuter says: " + jobKey + " executing at " + new Date());

        List<Schedule> scheduleList = scheduleRepository.findAll();
        LOG.info(scheduleList.toString());

        int x = 0;
    }

}

