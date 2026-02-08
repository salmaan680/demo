import React, { useContext } from 'react';
import { AuthContext } from '../context/AuthContext';
import { FaSignOutAlt, FaBell } from 'react-icons/fa';

const Navbar = () => {
    const { logout } = useContext(AuthContext);

    return (
        <header className="bg-white shadow-sm h-16 flex items-center justify-between px-6 z-10">
            <div>
                <h2 className="text-xl font-semibold text-gray-800">Overview</h2>
            </div>
            <div className="flex items-center gap-4">
                <button className="p-2 text-gray-500 hover:text-blue-600 transition-colors relative">
                    <FaBell size={20} />
                    <span className="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
                <div className="h-8 w-[1px] bg-gray-200"></div>
                <button
                    onClick={logout}
                    className="flex items-center gap-2 text-gray-600 hover:text-red-600 transition-colors font-medium text-sm"
                >
                    <FaSignOutAlt />
                    Logout
                </button>
            </div>
        </header>
    );
};

export default Navbar;
