
const apiConfig = {
    cinema: {
        search: {
            url: '/Ajax/cinemaSearch',
            requestData: function(term) {
                return {
                    nom: term
                };
            }
        }
    },
    ville: {
        search: {
            url: '/Ajax/villeSearch',
            requestData: function(term) {
                return {
                    nom: term
                };
            }
        }
    },
};

export default apiConfig;
