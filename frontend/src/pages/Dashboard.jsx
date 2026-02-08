import React from 'react';

const Dashboard = () => {
    return (
        <div>
            <h1 className="text-3xl font-bold mb-6">Dashboard</h1>
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div className="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 className="text-gray-500 text-sm font-medium">Total Vehicles</h3>
                    <p className="text-3xl font-bold text-gray-800 mt-2">12</p>
                    <span className="text-green-500 text-sm mt-2 block">+2 this month</span>
                </div>
                <div className="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 className="text-gray-500 text-sm font-medium">Active Trips</h3>
                    <p className="text-3xl font-bold text-gray-800 mt-2">5</p>
                    <span className="text-blue-500 text-sm mt-2 block">Currently running</span>
                </div>
                <div className="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 className="text-gray-500 text-sm font-medium">Maintenance</h3>
                    <p className="text-3xl font-bold text-gray-800 mt-2">2</p>
                    <span className="text-red-500 text-sm mt-2 block">Needs attention</span>
                </div>
                <div className="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 className="text-gray-500 text-sm font-medium">Fuel Cost (M)</h3>
                    <p className="text-3xl font-bold text-gray-800 mt-2">$2,450</p>
                    <span className="text-gray-400 text-sm mt-2 block">Last 30 days</span>
                </div>
            </div>
            {/* Charts would go here */}
        </div>
    );
};

export default Dashboard;
