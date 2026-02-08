import React, { useEffect, useState } from 'react';
import api from '../services/api';
import { FaPlus, FaEdit, FaTrash } from 'react-icons/fa';

const Vehicles = () => {
    const [vehicles, setVehicles] = useState([]);
    const [loading, setLoading] = useState(true);
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [formData, setFormData] = useState({
        plateNumber: '',
        model: '',
        year: '',
        fuelType: 'Diesel',
        capacity: '',
        status: 'active'
    });

    useEffect(() => {
        fetchVehicles();
    }, []);

    const fetchVehicles = async () => {
        try {
            const { data } = await api.get('/vehicles');
            setVehicles(data);
            setLoading(false);
        } catch (error) {
            console.error('Error fetching vehicles:', error);
            setLoading(false);
        }
    };

    const handleInputChange = (e) => {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const { data } = await api.post('/vehicles', formData);
            setVehicles([...vehicles, data]);
            setIsModalOpen(false);
            setFormData({
                plateNumber: '',
                model: '',
                year: '',
                fuelType: 'Diesel',
                capacity: '',
                status: 'active'
            });
        } catch (error) {
            console.error('Error adding vehicle:', error);
            alert('Failed to add vehicle');
        }
    };

    if (loading) return <p>Loading...</p>;

    return (
        <div>
            <div className="flex justify-between items-center mb-6">
                <h1 className="text-2xl font-bold">Vehicles</h1>
                <button
                    onClick={() => setIsModalOpen(true)}
                    className="bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-blue-700"
                >
                    <FaPlus /> Add Vehicle
                </button>
            </div>

            {/* Modal */}
            {isModalOpen && (
                <div className="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50">
                    <div className="relative p-5 border w-96 shadow-lg rounded-md bg-white">
                        <div className="mt-3">
                            <h3 className="text-lg leading-6 font-medium text-gray-900 mb-4">Add New Vehicle</h3>
                            <form onSubmit={handleSubmit}>
                                <div className="mb-4">
                                    <label className="block text-gray-700 text-sm font-bold mb-2">Plate Number</label>
                                    <input
                                        type="text"
                                        name="plateNumber"
                                        value={formData.plateNumber}
                                        onChange={handleInputChange}
                                        className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        required
                                    />
                                </div>
                                <div className="mb-4">
                                    <label className="block text-gray-700 text-sm font-bold mb-2">Model</label>
                                    <input
                                        type="text"
                                        name="model"
                                        value={formData.model}
                                        onChange={handleInputChange}
                                        className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        required
                                    />
                                </div>
                                <div className="mb-4">
                                    <label className="block text-gray-700 text-sm font-bold mb-2">Year</label>
                                    <input
                                        type="number"
                                        name="year"
                                        value={formData.year}
                                        onChange={handleInputChange}
                                        className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        required
                                    />
                                </div>
                                <div className="mb-4">
                                    <label className="block text-gray-700 text-sm font-bold mb-2">Fuel Type</label>
                                    <select
                                        name="fuelType"
                                        value={formData.fuelType}
                                        onChange={handleInputChange}
                                        className="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    >
                                        <option value="Diesel">Diesel</option>
                                        <option value="Petrol">Petrol</option>
                                        <option value="Electric">Electric</option>
                                        <option value="Hybrid">Hybrid</option>
                                    </select>
                                </div>
                                <div className="mb-4">
                                    <label className="block text-gray-700 text-sm font-bold mb-2">Capacity</label>
                                    <input
                                        type="text"
                                        name="capacity"
                                        value={formData.capacity}
                                        onChange={handleInputChange}
                                        className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    />
                                </div>
                                <div className="flex items-center justify-between mt-6">
                                    <button
                                        type="button"
                                        onClick={() => setIsModalOpen(false)}
                                        className="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        type="submit"
                                        className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                    >
                                        Save Vehicle
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            )}

            <div className="bg-white rounded-lg shadow overflow-hidden">
                <table className="min-w-full divide-y divide-gray-200">
                    <thead className="bg-gray-50">
                        <tr>
                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plate</th>
                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model</th>
                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fuel Type</th>
                            <th className="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody className="bg-white divide-y divide-gray-200">
                        {vehicles.map((vehicle) => (
                            <tr key={vehicle._id}>
                                <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{vehicle.plateNumber}</td>
                                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{vehicle.model} ({vehicle.year})</td>
                                <td className="px-6 py-4 whitespace-nowrap">
                                    <span className={`px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        ${vehicle.status === 'active' ? 'bg-green-100 text-green-800' :
                                            vehicle.status === 'maintenance' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'}`}>
                                        {vehicle.status}
                                    </span>
                                </td>
                                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{vehicle.fuelType}</td>
                                <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button className="text-indigo-600 hover:text-indigo-900 mr-4"><FaEdit /></button>
                                    <button className="text-red-600 hover:text-red-900"><FaTrash /></button>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </div>
    );
};

export default Vehicles;
