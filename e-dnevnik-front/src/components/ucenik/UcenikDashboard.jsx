import React, { useState, useEffect } from "react";
import axios from "axios";

const UcenikDashboard = () => {
    const [ocene, setOcene] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    const [filter, setFilter] = useState("sve"); // "sve", "ocenjeno", "nije_ocenjeno"
    const [sortOrder, setSortOrder] = useState("desc"); // "asc" ili "desc"

    const token = sessionStorage.getItem("access_token");

    const fetchOcene = async () => {
        try {
            const response = await axios.get("http://127.0.0.1:8000/api/ocene/moje", {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            });
            setOcene(response.data.data);
        } catch (error) {
            console.error("Greška prilikom učitavanja ocena:", error);
            setError("Greška pri učitavanju ocena.");
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchOcene();
    }, []);

    const filtriraneOcene = ocene.filter((ocena) => {
        if (filter === "ocenjeno") {
            return ocena.ocena !== null;
        } else if (filter === "nije_ocenjeno") {
            return ocena.ocena === null;
        }
        return true;
    });
    
    const sortiraneOcene = [...filtriraneOcene].sort((a, b) => {
        if (sortOrder === "asc") {
            return (a.ocena || 0) - (b.ocena || 0);
        } else {
            return (b.ocena || 0) - (a.ocena || 0);
        }
    });

//za prikaz tackica za tezinu
const renderTezina = (tezina) => {
    return (
        <div className="tezina-container">
            {[...Array(5)].map((_, index) => (
                <span
                    key={index} className={`tezina-dot ${index < tezina ? "active" : ""}`}>
                    ●
                </span>
             ))}
        </div>
    );
};

    return (
        <div className="ucenik-dashboard">
            <h2>Moje Ocene</h2>
            {loading && <p>Učitavanje...</p>}
            {error && <p style={{ color: "red" }}>{error}</p>}

            <div className="filter-sort-container">
                <label>Filtriraj:</label>
                <select onChange={(e) => setFilter(e.target.value)} value={filter}>
                    <option value="sve">Sve ocene</option>
                    <option value="ocenjeno">Samo ocenjeno</option>
                    <option value="nije_ocenjeno">Samo nije ocenjeno</option>
                </select>

                <label>Sortiraj:</label>
                <select onChange={(e) => setSortOrder(e.target.value)} value={sortOrder}>
                    <option value="desc">Najveće ocene prvo</option>
                    <option value="asc">Najmanje ocene prvo</option>
                </select>
            </div>

            <div className="ocene-container">
                {sortiraneOcene.map((ocena) => (
                    <div key={ocena.id} className="ocena-card">
                        <div className="card-header">
                            {ocena.predmet.naziv}
                        </div>
                        <div className="card-body">
                            <h3>{ocena.predmet.opis}</h3>

                            <div className="progress-bar">
                            <div
                                className="progress-bar-fill"
                                style={{ width: `${(ocena.ocena / 5) * 100}%` }}
                            >
                                {ocena.ocena ? ocena.ocena : "N/A"}
                            </div>
                        </div>
                            <div className="tezina-wrapper">
                                <strong>Težina:</strong>
                                {renderTezina(ocena.predmet.tezina)}
                            </div>

                            <p><strong>Profesor:</strong> {ocena.predmet.profesor ? ocena.predmet.profesor.ime : "Nepoznato"}</p>
                        </div>

                       
                        <p><strong>Datum ocene:</strong> {ocena.datum}</p>
                        <p><strong>Komentar profesora:</strong> {ocena.komentar}</p>
                    </div>
                ))}
            </div>
        </div>
    );
};

export default UcenikDashboard;
