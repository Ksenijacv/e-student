import React, { useState } from "react";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Navbar from "./components/Navbar";
import LoginForm from "./components/Login";
import RegisterForm from "./components/Register";
import ProfesorDashboard from "./components/ProfesorDashboard";
import UcenikDashboard from "./components/UcenikDashboard";
import RoditeljDashboard from "./components/RoditeljDashboard";

function App() {
    const [token, setToken] = useState(sessionStorage.getItem("access_token"));
    const [tipKorisnika, setTipKorisnika] = useState(sessionStorage.getItem("tip_korisnika"));
    const [relatedModelId, setRelatedModelId] = useState(sessionStorage.getItem("related_model_id"));

    console.log("Token:", token);

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
                    <Route path="/login" element={<LoginForm setToken={setToken} setTipKorisnika={setTipKorisnika} setRelatedModelId={setRelatedModelId} />} />
                    <Route path="/register" element={<RegisterForm />} />

                    {token && (
                        <>
                            {tipKorisnika === "profesor" && (
                                <Route path="/dashboard" element={<ProfesorDashboard relatedModelId={relatedModelId} />} />
                            )}
                            {tipKorisnika === "ucenik" && (
                                <Route path="/dashboard" element={<UcenikDashboard relatedModelId={relatedModelId} />} />
                            )}
                            {tipKorisnika === "roditelj" && (
                                <Route path="/dashboard" element={<RoditeljDashboard relatedModelId={relatedModelId} />} />
                            )}
                        </>
                    )}
                </Routes>
            </BrowserRouter>
        </div>
    );
}

export default App;
