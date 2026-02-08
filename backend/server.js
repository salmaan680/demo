const express = require('express');
const dotenv = require('dotenv');
const cors = require('cors');
const connectDB = require('./config/db');

// Load env vars
dotenv.config();

// Connect to database
connectDB();

const app = express();

// Middleware
app.use(express.json());
app.use(cors());

// Routes
app.use('/api/auth', require('./routes/authRoutes'));
app.use('/api/vehicles', require('./routes/vehicleRoutes'));
app.use('/api/drivers', require('./routes/driverRoutes'));
app.use('/api/trips', require('./routes/tripRoutes'));
app.use('/api/fuel', require('./routes/fuelRoutes'));
app.use('/api/maintenance', require('./routes/maintenanceRoutes'));

const PORT = process.env.PORT || 5000;

app.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);
});
