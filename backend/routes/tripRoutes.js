const express = require('express');
const router = express.Router();
const {
    getTrips,
    getTripById,
    createTrip,
    updateTrip
} = require('../controllers/tripController');
const { protect } = require('../middleware/authMiddleware');

router.route('/')
    .get(protect, getTrips)
    .post(protect, createTrip);

router.route('/:id')
    .get(protect, getTripById)
    .put(protect, updateTrip);

module.exports = router;
