package com.sec.rechs.DTOs;

import java.util.HashMap;

/**
 * <h1>Data Transfer Object: Account</h1>
 *
 * <p>
 * Contains all related attributes and their getters and setters
 * </p>
 *
 * @Author  Ahmed Al-Adaileh <k1530383@kingston.ac.uk> <ahmed.adaileh@gmail.com>
 * @version 1.0
 * @since   26.01.2018
 */
public class Account {

    private String clientId;
    private HashMap<Integer, Transaction> TransactionList;

    public String getClientId() {
        return clientId;
    }

    public void setClientId(String clientId) {
        this.clientId = clientId;
    }

    public HashMap<Integer, Transaction> getTransactionList() {
        return TransactionList;
    }

    public void setTransactionList(HashMap<Integer, Transaction> transactionList) {
        TransactionList = transactionList;
    }
}
