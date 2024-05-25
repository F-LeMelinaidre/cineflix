import apiConfig from "../api/apiConfig";

export class CinemaVilleInput {

    /** @type {HTMLElement} */
    #inputCinema
    /** @type {HTMLElement} */
    #inputVille
    /** @type {Array} */
    #instancesAutoComplete = []

    constructor() {

        this.#inputCinema = document.getElementById('InputCinema');
        this.#inputVille = document.getElementById('InputVille');

        if(this.#inputCinema && this.#inputCinema) {
            this.#init();
        } else {
            console.log("Input manquant !");
        }

    }

    async #init() {

        const importAutocomplete = async (params) => {
            const { InputAutocomplete } = await import('./InputAutcomplete');

            const autocomplete = new InputAutocomplete({
                input: params.input,
                label: params.label,
                templateLabel: params.templateLabel,
                value: params.value,
                request: params.request
            });

            autocomplete.setupAutocomplete();

            return autocomplete;
        };

        const cinemaParams = {
            input: this.#inputCinema,
            templateLabel: (item) => [item.nom, item.ville.nom],
            value: 'id',
            request: apiConfig.cinema.search
        };

        const villeParams = {
            input: this.#inputVille,
            label: 'nom',
            value: 'id',
            request: apiConfig.ville.search
        };

        const [cinema, ville] = await Promise.all([
            importAutocomplete(cinemaParams),
            importAutocomplete(villeParams)
        ]);

        $(this.#inputCinema).on('inputChange', (event, value) => {
            $(this.#inputVille).val(value.ville.nom);

            let changeEvent = new Event('autocomplete', {
                bubbles: true,
                cancelable: true
            });

            this.#inputVille.dispatchEvent(changeEvent);
        });
    }
}

const inputs = new CinemaVilleInput();