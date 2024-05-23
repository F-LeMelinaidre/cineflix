
export const cinemaSearch = (term, callback) => {

    $.ajax({
        url: '/Ajax/cinemaSearch',
        dataType: 'json',
        data: {
            nom: term
        },
        success: function(data) {
            callback(data);
        },
        error: function(xhr, status, error) {
            console.error("Erreur lors de la requête Cinema Search :", error);

            callback({ error: "Erreur lors de la requête Cinema Search" });
        }
    });

};