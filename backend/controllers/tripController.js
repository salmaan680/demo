const Trip = require('../models/Trip');

// @desc    Get all trips
// @route   GET /api/trips
// @access  Private
const getTrips = async (req, res) => {
    const trips = await Trip.find({})
        .populate('vehicle', 'plateNumber model')
        .populate('driver', 'licenseNumber'); // Could populate user name from driver too
    res.json(trips);
};

// @desc    Get single trip
// @route   GET /api/trips/:id
// @access  Private
const getTripById = async (req, res) => {
    const trip = await Trip.findById(req.params.id)
        .populate('vehicle')
        .populate('driver');

    if (trip) {
        res.json(trip);
    } else {
        res.status(404).json({ message: 'Trip not found' });
    }
};

// @desc    Create a trip
// @route   POST /api/trips
// @access  Private/Admin/Manager
const createTrip = async (req, res) => {
    const { vehicle, driver, startLocation, endLocation, startTime, notes } = req.body;

    const trip = await Trip.create({
        vehicle,
        driver,
        startLocation,
        endLocation,
        startTime,
        notes,
        status: 'scheduled'
    });

    if (trip) {
        res.status(201).json(trip);
    } else {
        res.status(400).json({ message: 'Invalid trip data' });
    }
};

// @desc    Update trip status (Start, Complete, Cancel)
// @route   PUT /api/trips/:id
// @access  Private
const updateTrip = async (req, res) => {
    const trip = await Trip.findById(req.params.id);

    if (trip) {
        trip.status = req.body.status || trip.status;
        trip.endTime = req.body.endTime || trip.endTime;
        trip.distance = req.body.distance || trip.distance;
        trip.notes = req.body.notes || trip.notes;

        const updatedTrip = await trip.save();
        res.json(updatedTrip);
    } else {
        res.status(404).json({ message: 'Trip not found' });
    }
};

module.exports = {
    getTrips,
    getTripById,
    createTrip,
    updateTrip
};
