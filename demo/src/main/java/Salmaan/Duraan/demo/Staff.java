package Salmaan.Duraan.demo;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Data
@AllArgsConstructor
@NoArgsConstructor
public class Staff {
    private long staff_id;
    private String staff_name;
    private String role;


    public Long getStaff_id() {
        return getStaff_id();
    }
}

