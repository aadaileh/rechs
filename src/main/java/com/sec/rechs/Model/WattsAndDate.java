package com.sec.rechs.Model;

import javax.validation.constraints.NotBlank;
import javax.validation.constraints.NotEmpty;
import javax.validation.constraints.NotNull;
import java.util.Date;

public interface WattsAndDate {

    Long getId();

    @NotNull
    @NotBlank
    @NotEmpty
    String getWatts();

    Date getCreatedTimestamp();
}
