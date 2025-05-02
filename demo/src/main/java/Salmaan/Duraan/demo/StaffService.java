package Salmaan.Duraan.demo;

import org.springframework.stereotype.Service;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

@Service
public class StaffService {
    private  final Map<Long, Staff> staffMap = new HashMap();


    public List<Staff> getAllStaff() {
        return new ArrayList(staffMap.values());
    }
    public Staff getStaffById(Long id) {
        return staffMap.get(id);
    }
    public Staff createStaff(Staff staff) {
        staffMap.put(staff.getStaff_id(), staff);
        return staff;
    }
    public Staff updateStaff(Long id, Staff updatedStaff) {
        staffMap.put(id, updatedStaff);
        return updatedStaff;
    }
    public void deleteStaff(Long id) {
        staffMap.remove(id);
        return;
    }
}
