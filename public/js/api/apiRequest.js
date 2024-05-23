
import apiConfig from './apiConfig';

export default function apiRequest(url, requestData, callback) {
    const api = apiConfig;
    console.log(api)

    if (!api) {
        console.error("API non trouvée :", apiName);
        callback({ error: "API non trouvée" });
        return;
    }


    $.ajax({
        url: url,
        dataType: 'json',
        data: requestData,
        success: function(data) {
            callback(data);
        },
        error: function(xhr, status, error) {
            console.error("Erreur lors de la requête :", error);
            callback({ error: "Erreur lors de la requête" });
        }
    });
}