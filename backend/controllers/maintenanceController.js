const MaintenanceLog = require('../models/MaintenanceLog');

// @desc    Get all maintenance logs
// @route   GET /api/maintenance
// @access  Private
const getMaintenanceLogs = async (req, res) => {
    const logs = await MaintenanceLog.find({}).populate('vehicle', 'plateNumber');
    res.json(logs);
};

// @desc    Add maintenance log
// @route   POST /api/maintenance
// @access  Private
const addMaintenanceLog = async (req, res) => {
    const { vehicle, description, cost, nextServiceDate, status, date } = req.body;

    const log = await MaintenanceLog.create({
        vehicle,
        description,
        cost,
        nextServiceDate,
        status,
        date
    });

    if (log) {
        res.status(201).json(log);
    } else {
        res.status(400).json({ message: 'Invalid maintenance data' });
    }
};

// @desc    Update maintenance status
// @route   PUT /api/maintenance/:id
// @access  Private
const updateMaintenanceLog = async (req, res) => {
    const log = await MaintenanceLog.findById(req.params.id);

    if (log) {
        log.status = req.body.status || log.status;
        log.nextServiceDate = req.body.nextServiceDate || log.nextServiceDate;

        const updatedLog = await log.save();
        res.json(updatedLog);
    } else {
        res.status(404).json({ message: 'Log not found' });
    }
};

module.exports = { getMaintenanceLogs, addMaintenanceLog, updateMaintenanceLog };
