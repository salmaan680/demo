const FuelLog = require('../models/FuelLog');

// @desc    Get all fuel logs
// @route   GET /api/fuel
// @access  Private
const getFuelLogs = async (req, res) => {
    const logs = await FuelLog.find({}).populate('vehicle', 'plateNumber');
    res.json(logs);
};

// @desc    Add fuel log
// @route   POST /api/fuel
// @access  Private
const addFuelLog = async (req, res) => {
    const { vehicle, amount, cost, mileage, date } = req.body;

    const log = await FuelLog.create({
        vehicle,
        amount,
        cost,
        mileage,
        date
    });

    if (log) {
        res.status(201).json(log);
    } else {
        res.status(400).json({ message: 'Invalid fuel data' });
    }
};

module.exports = { getFuelLogs, addFuelLog };
