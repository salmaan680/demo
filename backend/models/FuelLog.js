const mongoose = require('mongoose');

const fuelLogSchema = new mongoose.Schema({
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
    amount: {
        type: Number, // Liters/Gallons
        required: true
    },
    cost: {
        type: Number,
        required: true
    },
    mileage: {
        type: Number, // Odometer reading
        required: true
    },
    createdAt: {
        type: Date,
        default: Date.now
    }
});

module.exports = mongoose.model('FuelLog', fuelLogSchema);
