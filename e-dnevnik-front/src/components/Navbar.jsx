import React from "react";
import { Link, useNavigate } from "react-router-dom";

const Navbar = ({ token, setToken, tipKorisnika }) => {
    const navigate = useNavigate();

    const handleLogout = () => {
        sessionStorage.clear();
        setToken(null);
        navigate("/login");
    };

    return (
        <nav>
            <ul>
                {!token ? (
                    <>
                        <li>
                            <Link to="/login">Prijava</Link>
                        </li>
                        <li>
                            <Link to="/register">Registracija</Link>
                        </li>
                    </>
                ) : (
                    <>
                        {tipKorisnika === "profesor" && (
                            <li>
                                <Link to="/dashboard-profesor">Dashboard Profesora</Link>
                            </li>
                        )}
                        {tipKorisnika === "ucenik" && (
                            <li>
                                <Link to="/dashboard-ucenik">Dashboard Učenika</Link>
                            </li>
                        )}
                        {tipKorisnika === "roditelj" && (
                            <li>
                                <Link to="/dashboard-roditelj">Dashboard Roditelja</Link>
                            </li>
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
