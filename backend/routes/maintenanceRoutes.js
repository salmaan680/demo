const express = require('express');
const router = express.Router();
const { getMaintenanceLogs, addMaintenanceLog, updateMaintenanceLog } = require('../controllers/maintenanceController');
const { protect } = require('../middleware/authMiddleware');

router.route('/')
    .get(protect, getMaintenanceLogs)
    .post(protect, addMaintenanceLog);

router.route('/:id').put(protect, updateMaintenanceLog);

module.exports = router;
