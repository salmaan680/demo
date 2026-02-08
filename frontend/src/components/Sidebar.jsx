import React, { useContext } from 'react';
import { Link, useLocation } from 'react-router-dom';
import { AuthContext } from '../context/AuthContext';
import { FaTachometerAlt, FaCar, FaUserTie, FaRoute, FaGasPump, FaTools } from 'react-icons/fa';

const Sidebar = () => {
    const { user } = useContext(AuthContext);
    const location = useLocation();

    const menuItems = [
        { path: '/', label: 'Dashboard', icon: <FaTachometerAlt /> },
        { path: '/vehicles', label: 'Vehicles', icon: <FaCar /> },
        { path: '/drivers', label: 'Drivers', icon: <FaUserTie /> },
        { path: '/trips', label: 'Trips', icon: <FaRoute /> },
        { path: '/fuel', label: 'Fuel Logs', icon: <FaGasPump /> },
        { path: '/maintenance', label: 'Maintenance', icon: <FaTools /> },
    ];

    return (
        <div className="bg-gray-900 text-white w-64 min-h-screen p-4">
            <div className="flex items-center justify-center mb-8 mt-2">
                <h1 className="text-2xl font-bold text-blue-400">FleetManager</h1>
            </div>
            <div className="mb-4 px-2">
                <p className="text-gray-400 text-xs uppercase">Menu</p>
            </div>
            <nav>
                <ul>
                    {menuItems.map((item) => (
                        <li key={item.path} className="mb-2">
                            <Link
                                to={item.path}
                                className={`flex items-center p-3 rounded-lg transition-colors ${location.pathname === item.path
                                        ? 'bg-blue-600 text-white'
                                        : 'text-gray-300 hover:bg-gray-800 hover:text-white'
                                    }`}
                            >
                                <span className="mr-3">{item.icon}</span>
                                {item.label}
                            </Link>
                        </li>
                    ))}
                </ul>
            </nav>
            <div className="absolute bottom-4 left-4 right-4">
                <div className="bg-gray-800 p-3 rounded-lg border border-gray-700">
                    <div className="flex items-center">
                        <div className="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-xs font-bold">
                            {user?.name?.charAt(0)}
                        </div>
                        <div className="ml-3">
                            <p className="text-sm font-medium">{user?.name}</p>
                            <p className="text-xs text-gray-400 capitalize">{user?.role}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Sidebar;
