import React, { useContext } from 'react';
import { Routes, Route, Navigate } from 'react-router-dom';
import Login from './pages/Login';
import Dashboard from './pages/Dashboard';
import Vehicles from './pages/Vehicles';
import Drivers from './pages/Drivers';
import Trips from './pages/Trips';
import Fuel from './pages/Fuel';
import Maintenance from './pages/Maintenance';
import Layout from './components/Layout';
import { AuthContext } from './context/AuthContext';

function App() {
  const { user, loading } = useContext(AuthContext);

  if (loading) {
    return <div className="flex h-screen justify-center items-center">Loading...</div>;
  }

  return (
    <Routes>
      <Route path="/login" element={!user ? <Login /> : <Navigate to="/" />} />

      <Route element={user ? <Layout /> : <Navigate to="/login" />}>
        <Route path="/" element={<Dashboard />} />
        <Route path="/vehicles" element={<Vehicles />} />
        <Route path="/drivers" element={<Drivers />} />
        <Route path="/trips" element={<Trips />} />
        <Route path="/fuel" element={<Fuel />} />
        <Route path="/maintenance" element={<Maintenance />} />
      </Route>

      <Route path="*" element={<Navigate to="/" />} />
    </Routes>
  );
}

export default App;
