const Driver = require('../models/Driver');

// @desc    Get all drivers
// @route   GET /api/drivers
// @access  Private
const getDrivers = async (req, res) => {
    const drivers = await Driver.find({}).populate('user', 'name email');
    res.json(drivers);
};

// @desc    Get single driver
// @route   GET /api/drivers/:id
// @access  Private
const getDriverById = async (req, res) => {
    const driver = await Driver.findById(req.params.id).populate('user', 'name email');

    if (driver) {
        res.json(driver);
    } else {
        res.status(404).json({ message: 'Driver not found' });
    }
};

// @desc    Register a driver (Create profile)
// @route   POST /api/drivers
// @access  Private/Admin/Manager
const createDriver = async (req, res) => {
    const { user, licenseNumber, experience } = req.body;

    const driverExists = await Driver.findOne({ licenseNumber });

    if (driverExists) {
        res.status(400).json({ message: 'Driver license already exists' });
        return;
    }

    const driver = await Driver.create({
        user,
        licenseNumber,
        experience,
        status: 'available'
    });

    if (driver) {
        res.status(201).json(driver);
    } else {
        res.status(400).json({ message: 'Invalid driver data' });
    }
};

// @desc    Update driver
// @route   PUT /api/drivers/:id
// @access  Private/Admin/Manager
const updateDriver = async (req, res) => {
    const driver = await Driver.findById(req.params.id);

    if (driver) {
        driver.licenseNumber = req.body.licenseNumber || driver.licenseNumber;
        driver.experience = req.body.experience || driver.experience;
        driver.status = req.body.status || driver.status;
        driver.assignedVehicle = req.body.assignedVehicle || driver.assignedVehicle;

        const updatedDriver = await driver.save();
        res.json(updatedDriver);
    } else {
        res.status(404).json({ message: 'Driver not found' });
    }
};

// @desc    Delete driver
// @route   DELETE /api/drivers/:id
// @access  Private/Admin
const deleteDriver = async (req, res) => {
    const driver = await Driver.findById(req.params.id);

    if (driver) {
        await driver.deleteOne();
        res.json({ message: 'Driver removed' });
    } else {
        res.status(404).json({ message: 'Driver not found' });
    }
};

module.exports = {
    getDrivers,
    getDriverById,
    createDriver,
    updateDriver,
    deleteDriver
};
