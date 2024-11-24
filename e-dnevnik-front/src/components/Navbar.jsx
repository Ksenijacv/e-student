import React from "react";
import { Link, useNavigate } from "react-router-dom";
import axios from "axios";

const Navbar = ({ token, setToken, tipKorisnika, setTipKorisnika, setRelatedModelId }) => {
    let navigate = useNavigate();

    const handleLogout = async () => {
        try {
            await axios.post(
                "http://127.0.0.1:8000/api/logout",
                {},
                { headers: { Authorization: `Bearer ${token}` } }
            );

            console.log("Uspešna odjava!");
            console.log("Token uklonjen:", token);

            // Čišćenje sessionStorage i state-a
            sessionStorage.clear();
            setToken(null);
            setTipKorisnika(null);
            setRelatedModelId(null);

            // Preusmeravanje na početnu stranicu
            navigate("/");
        } catch (error) {
            console.error("Greška prilikom odjavljivanja:", error.response ? error.response.data : error.message);
        }
    };

    return (
        <nav>
            <ul>
                {/* Zajedničke rute za sve korisnike */}
               

                {!token ? (
                    // Rute za neregistrovane korisnike
                    <>
                        <li>
                            <Link to="/login">Prijava</Link>
                        </li>
                        <li>
                            <Link to="/register">Registracija</Link>
                        </li>
                    </>
                ) : (
                    // Rute za registrovane korisnike
                    <>
                        {tipKorisnika === "profesor" && (
                            <>
                                <li>
                                    <Link to="/dashboard">Dashboard Profesora</Link>
                                </li>
                               
                            </>
                        )}
                        {tipKorisnika === "ucenik" && (
                            <>
                                <li>
                                    <Link to="/dashboard">Dashboard Učenika</Link>
                                </li>
                                
                            </>
                        )}
                        {tipKorisnika === "roditelj" && (
                            <>
                                <li>
                                    <Link to="/dashboard">Dashboard Roditelja</Link>
                                </li>
                                
                            </>
                        )}
                        <li>
                            <button onClick={handleLogout}>Odjava</button>
                        </li>
                    </>
                )}
            </ul>
        </nav>
    );
};

export default Navbar;
