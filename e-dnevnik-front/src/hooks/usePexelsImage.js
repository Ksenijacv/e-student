import { useState, useEffect } from "react";
import axios from "axios";

const usePexelsImage = (query) => {
    const [imageUrl, setImageUrl] = useState(null);

    useEffect(() => {
        const fetchImage = async () => {
            try {
                const response = await axios.get("https://api.pexels.com/v1/search", {
                    headers: {
                        Authorization: "Ea60db14LXiDJ5K1WZ1RrnjIBm144EfaLzHK5q0fP1uAffcmLqfiB3Xw",
                    },
                    params: {
                        query: query,
                        per_page: 10,
                    },
                });

                if (response.data.photos.length > 0) {
                    const randomIndex = Math.floor(Math.random() * response.data.photos.length);
                    setImageUrl(response.data.photos[randomIndex].src.large);
                }
            } catch (error) {
                console.error("Greška prilikom dohvaćanja slike sa Pexels API-ja:", error);
            }
        };

        fetchImage();
    }, [query]);

    return imageUrl;
};

export default usePexelsImage;
