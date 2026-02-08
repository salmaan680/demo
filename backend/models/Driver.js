const mongoose = require('mongoose');

const driverSchema = new mongoose.Schema({
    user: {
        type: mongoose.Schema.Types.ObjectId,
        ref: 'User',
        required: true
    },
    licenseNumber: {
        type: String,
        required: true,
        unique: true
    },
    experience: {
        type: Number, // Years of experience
        required: true
    },
    status: {
        type: String,
        enum: ['available', 'on-trip', 'leave'],
        default: 'available'
    },
    assignedVehicle: {
        type: mongoose.Schema.Types.ObjectId,
        ref: 'Vehicle'
    },
    createdAt: {
        type: Date,
        default: Date.now
    }
});

module.exports = mongoose.model('Driver', driverSchema);
