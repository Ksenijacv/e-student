import React, { useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";

const RegisterForm = () => {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [tipKorisnika, setTipKorisnika] = useState("ucenik"); // Default tip korisnika
    const [error, setError] = useState("");
    const [success, setSuccess] = useState(false);
    let navigate = useNavigate();

    const handleSubmit = async (event) => {
        event.preventDefault();

        try {
            await axios.post("http://127.0.0.1:8000/api/register", {
                email,
                password,
                tip_korisnika: tipKorisnika,
            });

            console.log("Uspešna registracija!");
            console.log("Podaci poslati na backend:");
            console.log("Email:", email);
            console.log("Tip korisnika:", tipKorisnika);

            setSuccess(true);
            setError("");

            // Nakon uspešne registracije preusmerava korisnika na login
            setTimeout(() => navigate("/login"), 2000);
        } catch (error) {
            setError("Greška prilikom registracije. Proverite podatke i pokušajte ponovo.");
            console.error("Greška prilikom registracije:", error.response ? error.response.data : error.message);
        }
    };

    return (
        <div>
            <h2>Registracija</h2>
            {success && <p>Uspešno ste se registrovali! Preusmeravamo vas na prijavu...</p>}
            {error && <p style={{ color: "red" }}>{error}</p>}
            <form onSubmit={handleSubmit}>
                <label>
                    Email:
                    <input
                        type="email"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                        required
                    />
                </label>
                <label>
                    Lozinka:
                    <input
                        type="password"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                        required
                    />
                </label>
                <label>
                    Tip korisnika:
                    <select
                        value={tipKorisnika}
                        onChange={(e) => setTipKorisnika(e.target.value)}
                    >
                        <option value="profesor">Profesor</option>
                        <option value="ucenik">Učenik</option>
                        <option value="roditelj">Roditelj</option>
                    </select>
                </label>
                <button type="submit">Registruj se</button>
            </form>
        </div>
    );
};

export default RegisterForm;
