import React, { useState } from "react";
import axios from "axios";
import { useLocation, useNavigate } from "react-router-dom";

const UcenikForm = () => {
    const location = useLocation();
    const navigate = useNavigate();
    const { user_id } = location.state;

    const [ime, setIme] = useState("");
    const [razred, setRazred] = useState("");
    const [odeljenje, setOdeljenje] = useState("");
    const [roditeljId, setRoditeljId] = useState("");
    const [error, setError] = useState("");
    const [message, setMessage] = useState("");

    const handleSubmit = async (event) => {
        event.preventDefault();

        try {
            const response = await axios.post("http://127.0.0.1:8000/api/ucenik", {
                user_id,
                ime,
                razred,
                odeljenje,
                roditelj_id: roditeljId,
            });

            setMessage("Učenik uspešno kreiran!");
            console.log("Učenik kreiran:", response.data);
            alert("Uspesno ste uneli podatke za ucenika!");

            navigate("/");
        } catch (error) {
            console.error("Greška prilikom kreiranja učenika:", error.response ? error.response.data : error.message);
            setError("Greška prilikom kreiranja učenika. Proverite unete podatke.");
        }
    };

    return (
        <div className="user-page">
            
            {error && <p style={{ color: "red" }}>{error}</p>}
            {message && <p style={{ color: "green" }}>{message}</p>}
            <form  className="user-form" onSubmit={handleSubmit}>
            <h2>Dodavanje podataka za učenika</h2>
                <label>
                    Ime:
                    <input type="text" value={ime} onChange={(e) => setIme(e.target.value)} required />
                </label>
                <label>
                    Razred:
                    <input type="number" value={razred} onChange={(e) => setRazred(e.target.value)} required />
                </label>
                <label>
                    Odeljenje:
                    <input type="text" value={odeljenje} onChange={(e) => setOdeljenje(e.target.value)} required />
                </label>
                <label>
                    Roditelj ID (opciono):
                    <input type="text" value={roditeljId} onChange={(e) => setRoditeljId(e.target.value)} />
                </label>
                <button type="submit">Sačuvaj</button>
            </form>
        </div>
    );
};

export default UcenikForm;
