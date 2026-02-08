const express = require('express');
const router = express.Router();
const { getFuelLogs, addFuelLog } = require('../controllers/fuelController');
const { protect } = require('../middleware/authMiddleware');

router.route('/')
    .get(protect, getFuelLogs)
    .post(protect, addFuelLog);

module.exports = router;
