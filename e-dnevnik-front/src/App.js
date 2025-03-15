import React, { useState } from "react";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Navbar from "./components/Navbar";
import LoginForm from "./components/auth/LoginForm";
import RegisterForm from "./components/auth/RegisterForm";
import ProfesorForm from "./components/profesor/ProfesorForm";
import UcenikForm from "./components/ucenik/UcenikForm";
import RoditeljForm from "./components/roditelj/RoditeljForm";
import ProfesorDashboard from "./components/profesor/ProfesorDashboard";
import UcenikDashboard from "./components/ucenik/UcenikDashboard";
import RoditeljDashboard from "./components/roditelj/RoditeljDashboard";
import UcenikProfile from "./components/ucenik/UcenikProfile";
import './App.css';

function App() {
    const [token, setToken] = useState(sessionStorage.getItem("access_token"));
    const [tipKorisnika, setTipKorisnika] = useState(sessionStorage.getItem("tip_korisnika"));
    const [relatedModelId, setRelatedModelId] = useState(sessionStorage.getItem("related_model_id"));


    console.log("Token:", token);
    console.log("Tip korisnika:", tipKorisnika);
    console.log("ID povezanog modela:", relatedModelId);

    return (
        <div className="App">
            <BrowserRouter>
                <Navbar
                    token={token}
                    setToken={setToken}
                    tipKorisnika={tipKorisnika}
                    setTipKorisnika={setTipKorisnika}
                    setRelatedModelId={setRelatedModelId}
                />
                <Routes>
                    {/* Opšte rute za sve korisnike */}
                    
                    <Route
                        path="/"
                        element={
                            <LoginForm
                                setToken={setToken}
                                setTipKorisnika={setTipKorisnika}
                                setRelatedModelId={setRelatedModelId}
                            />
                        }
                    />
                    <Route path="/register" element={<RegisterForm />} />

                    {/* Rute za unos dodatnih podataka nakon registracije */}
                    {!token && (
                        <>
                            <Route path="/profesor" element={<ProfesorForm />} />
                            <Route path="/ucenik" element={<UcenikForm />} />
                            <Route path="/roditelj" element={<RoditeljForm />} />
                        </>
                    )}

                    {/* Dashboard rute za ulogovane korisnike */}
                    {token && tipKorisnika === "profesor" && (
                        <>
                        <Route path="/dashboard-profesor" element={<ProfesorDashboard />} />
                        </>
                    )}

                    {token && tipKorisnika === "ucenik" && (
                        <>
                        <Route path="/dashboard-ucenik" element={<UcenikDashboard />} />
                        <Route path="/ucenik-profile" element={<UcenikProfile />} />
                        </>
                    )}

                    {token && tipKorisnika === "roditelj" && (
                        <>
                        <Route path="/dashboard-roditelj" element={<RoditeljDashboard />} />
                        </>
                    )}
                </Routes>
            </BrowserRouter>
        </div>
    );
}

export default App;
