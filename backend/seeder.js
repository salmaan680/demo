const mongoose = require('mongoose');
const dotenv = require('dotenv');
const connectDB = require('./config/db');
const User = require('./models/User');
const Vehicle = require('./models/Vehicle');
const Driver = require('./models/Driver');

dotenv.config();
connectDB();

const importData = async () => {
    try {
        await User.deleteMany();
        await Vehicle.deleteMany();
        await Driver.deleteMany();

        const users = [
            {
                name: 'Admin User',
                email: 'admin@example.com',
                password: 'password123',
                role: 'admin'
            },
            {
                name: 'Manager User',
                email: 'manager@example.com',
                password: 'password123',
                role: 'manager'
            },
            {
                name: 'Driver User',
                email: 'driver@example.com',
                password: 'password123',
                role: 'driver'
            }
        ];

        const createdUsers = [];
        for (const user of users) {
            const newUser = await User.create(user);
            createdUsers.push(newUser);
        }

        const adminUser = createdUsers[0]._id;
        const driverUser = createdUsers[2]._id;

        const vehicles = await Vehicle.insertMany([
            {
                plateNumber: 'ABC-1234',
                model: 'Toyota HiAce',
                year: 2020,
                fuelType: 'Diesel',
                capacity: '14 Seats',
                status: 'active'
            },
            {
                plateNumber: 'XYZ-5678',
                model: 'Isuzu Elf',
                year: 2019,
                fuelType: 'Diesel',
                capacity: '3 Tons',
                status: 'active'
            }
        ]);

        await Driver.create({
            user: driverUser,
            licenseNumber: 'L-987654321',
            experience: 5,
            status: 'available',
            assignedVehicle: vehicles[0]._id
        });

        console.log('Data Imported!');
        process.exit();
    } catch (error) {
        console.error(`${error}`);
        process.exit(1);
    }
};

if (process.argv[2] === '-d') {
    // destroyData();
} else {
    importData();
}
