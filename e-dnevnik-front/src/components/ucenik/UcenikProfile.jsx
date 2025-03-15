import React, { useState, useEffect } from "react";
import axios from "axios";
import EditModal from "../EditModal";
import { useLocation } from "react-router-dom";

const UcenikProfile = () => {
    const [ucenik, setUcenik] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [editableFields, setEditableFields] = useState({});

    // Uzimamo podatke iz sessionStorage
    const [ucenikId, setUcenikId] = useState(sessionStorage.getItem("related_model_id"));
    const [token, setToken] = useState(sessionStorage.getItem("access_token"));

    console.log("ID povezanog modela:", ucenikId);
    console.log("Token:", token);

    const fetchUcenik = async () => {
        if (!ucenikId || !token) {
            setError("Nedostaju podaci za autentifikaciju.");
            return;
        }

        try {
            const response = await axios.get(`http://127.0.0.1:8000/api/ucenici/${ucenikId}`, {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            });


            setUcenik(response.data.data);
            setEditableFields({
                razred: response.data.razred,
                odeljenje: response.data.odeljenje,
                roditelj_id: response.data.roditelj ? response.data.roditelj.id : "",
            });

        } catch (err) {
            console.error("Greška prilikom učitavanja profila učenika:", err);
            setError("Greška prilikom učitavanja profila učenika.");
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        if (!ucenikId || !token) {
            console.error("Ne može se pozvati fetchUcenik() jer nema `ucenikId` ili `token`.");
            return;
        }
    
        fetchUcenik();
    }, [ucenikId, token]);

   

    const handleUpdate = async (updatedData) => {
        try {
            const response = await axios.put(
                `http://127.0.0.1:8000/api/ucenici/${ucenikId}`,
                updatedData,
                {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        "Content-Type": "application/json",
                    },
                }
            );
    
            // Odmah ažuriramo podatke učenika u state-u
            setUcenik((prev) => ({
                ...prev,
                ...response.data.ucenik, 
                roditelj: response.data.ucenik.roditelj 
            }));
    
            setIsModalOpen(false); // Zatvaramo modal
            alert("Profil uspešno ažuriran!");
        } catch (err) {
            console.error("Greška pri ažuriranju učenika:", err);
            alert("Greška pri ažuriranju profila.");
        }
    };

    return (
        <div className="profile-page">
            <h2>Moj Profil</h2>

            {loading && <p>Učitavanje podataka...</p>}
            {error && <p style={{ color: "red" }}>{error}</p>}

            {ucenik && (
                <div className="profile-container">
                    <p><strong>Ime:</strong> {ucenik.ime}</p>
                    <p><strong>Razred:</strong> {ucenik.razred}</p>
                    <p><strong>Odeljenje:</strong> {ucenik.odeljenje}</p>

                    {ucenik.roditelj ? (
                        <div className="roditelj-info">
                            <p><strong>Roditelj:</strong> {ucenik.roditelj.ime} {ucenik.roditelj.prezime}</p>
                            <p><strong>Kontakt:</strong> {ucenik.roditelj.kontakt}</p>
                        </div>
                    ) : (
                        <p><strong>Roditelj:</strong> Nema podataka</p>
                    )}

                    <button className="edit-btn" onClick={() => setIsModalOpen(true)}>Ažuriraj profil</button>
                </div>
            )}

            {/* Modal sa samo dozvoljenim poljima za edit */}
            <EditModal
                isOpen={isModalOpen}
                onClose={() => setIsModalOpen(false)}
                user={editableFields}
                onSave={handleUpdate}
            />
        </div>
    );
};

export default UcenikProfile;
