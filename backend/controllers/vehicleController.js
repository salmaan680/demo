const Vehicle = require('../models/Vehicle');

// @desc    Get all vehicles
// @route   GET /api/vehicles
// @access  Private
const getVehicles = async (req, res) => {
    const vehicles = await Vehicle.find({});
    res.json(vehicles);
};

// @desc    Get single vehicle
// @route   GET /api/vehicles/:id
// @access  Private
const getVehicleById = async (req, res) => {
    const vehicle = await Vehicle.findById(req.params.id);

    if (vehicle) {
        res.json(vehicle);
    } else {
        res.status(404).json({ message: 'Vehicle not found' });
    }
};

// @desc    Create a vehicle
// @route   POST /api/vehicles
// @access  Private/Admin/Manager
const createVehicle = async (req, res) => {
    const { plateNumber, model, year, fuelType, capacity } = req.body;

    const vehicleExists = await Vehicle.findOne({ plateNumber });

    if (vehicleExists) {
        res.status(400).json({ message: 'Vehicle already exists' });
        return;
    }

    const vehicle = await Vehicle.create({
        plateNumber,
        model,
        year,
        fuelType,
        capacity,
        status: 'active'
    });

    if (vehicle) {
        res.status(201).json(vehicle);
    } else {
        res.status(400).json({ message: 'Invalid vehicle data' });
    }
};

// @desc    Update a vehicle
// @route   PUT /api/vehicles/:id
// @access  Private/Admin/Manager
const updateVehicle = async (req, res) => {
    const vehicle = await Vehicle.findById(req.params.id);

    if (vehicle) {
        vehicle.plateNumber = req.body.plateNumber || vehicle.plateNumber;
        vehicle.model = req.body.model || vehicle.model;
        vehicle.year = req.body.year || vehicle.year;
        vehicle.status = req.body.status || vehicle.status;
        vehicle.fuelType = req.body.fuelType || vehicle.fuelType;
        vehicle.capacity = req.body.capacity || vehicle.capacity;

        const updatedVehicle = await vehicle.save();
        res.json(updatedVehicle);
    } else {
        res.status(404).json({ message: 'Vehicle not found' });
    }
};

// @desc    Delete a vehicle
// @route   DELETE /api/vehicles/:id
// @access  Private/Admin
const deleteVehicle = async (req, res) => {
    const vehicle = await Vehicle.findById(req.params.id);

    if (vehicle) {
        await vehicle.deleteOne();
        res.json({ message: 'Vehicle removed' });
    } else {
        res.status(404).json({ message: 'Vehicle not found' });
    }
};

module.exports = {
    getVehicles,
    getVehicleById,
    createVehicle,
    updateVehicle,
    deleteVehicle
};
