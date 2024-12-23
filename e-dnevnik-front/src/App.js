import React, { useState } from "react";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Navbar from "./components/Navbar";
import LoginForm from "./components/LoginForm";
import RegisterForm from "./components/RegisterForm";
import ProfesorForm from "./components/ProfesorForm";
import UcenikForm from "./components/UcenikForm";
import RoditeljForm from "./components/RoditeljForm";
import ProfesorDashboard from "./components/ProfesorDashboard";
import UcenikDashboard from "./components/UcenikDashboard";
import RoditeljDashboard from "./components/RoditeljDashboard";

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
                        path="/login"
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
                        <Route path="/dashboard-profesor" element={<ProfesorDashboard />} />
                    )}
                    {token && tipKorisnika === "ucenik" && (
                        <Route path="/dashboard-ucenik" element={<UcenikDashboard />} />
                    )}
                    {token && tipKorisnika === "roditelj" && (
                        <Route path="/dashboard-roditelj" element={<RoditeljDashboard />} />
                    )}
                </Routes>
            </BrowserRouter>
        </div>
    );
}

export default App;
