package com.sec.rechs.Repository;

import com.sec.rechs.Model.User;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface UsersManagementRepository extends JpaRepository<User, Long> {

}