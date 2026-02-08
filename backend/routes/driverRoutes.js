const express = require('express');
const router = express.Router();
const {
    getDrivers,
    getDriverById,
    createDriver,
    updateDriver,
    deleteDriver
} = require('../controllers/driverController');
const { protect, admin } = require('../middleware/authMiddleware');

router.route('/')
    .get(protect, getDrivers)
    .post(protect, createDriver);

router.route('/:id')
    .get(protect, getDriverById)
    .put(protect, updateDriver)
    .delete(protect, admin, deleteDriver);

module.exports = router;
