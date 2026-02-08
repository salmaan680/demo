const mongoose = require('mongoose');

const maintenanceLogSchema = new mongoose.Schema({
    vehicle: {
        type: mongoose.Schema.Types.ObjectId,
        ref: 'Vehicle',
        required: true
    },
    date: {
        type: Date,
        required: true,
        default: Date.now
    },
    description: {
        type: String,
        required: true
    },
    cost: {
        type: Number,
        required: true
    },
    nextServiceDate: {
        type: Date
    },
    status: {
        type: String,
        enum: ['pending', 'completed'],
        default: 'completed'
    },
    createdAt: {
        type: Date,
        default: Date.now
    }
});

module.exports = mongoose.model('MaintenanceLog', maintenanceLogSchema);
