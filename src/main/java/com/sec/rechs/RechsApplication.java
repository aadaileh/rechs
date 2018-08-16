package com.sec.rechs;

import com.sec.rechs.Services.HeartBeat.SimpleExample;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.boot.orm.jpa.EntityScan;
import org.springframework.data.jpa.repository.config.EnableJpaAuditing;
import org.springframework.data.jpa.repository.config.EnableJpaRepositories;

@SpringBootApplication
@EnableJpaAuditing
@EnableJpaRepositories("com.sec.rechs.Repository")
@EntityScan("com.sec.rechs.Model")
public class RechsApplication {

	public static void main(String[] args) throws Exception {

		SpringApplication.run(RechsApplication.class, args);

		SimpleExample simpleExample = new SimpleExample();
		simpleExample.run();
	}
}
