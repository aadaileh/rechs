package com.sec.rechs.Repository;

import com.sec.rechs.Model.User;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface AuthenticationRepository extends JpaRepository<User, Long> {

    User findByUsernameAndPassword(String username, String password);
}