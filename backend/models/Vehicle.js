const mongoose = require('mongoose');

const vehicleSchema = new mongoose.Schema({
    plateNumber: {
        type: String,
        required: true,
        unique: true
    },
    model: {
        type: String,
        required: true
    },
    year: {
        type: Number,
        required: true
    },
    status: {
        type: String,
        enum: ['active', 'maintenance', 'inactive'],
        default: 'active'
    },
    fuelType: {
        type: String,
        required: true
    },
    capacity: {
        type: String
    },
    createdAt: {
        type: Date,
        default: Date.now
    }
});

module.exports = mongoose.model('Vehicle', vehicleSchema);
