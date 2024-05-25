import apiRequest from "../api/apiRequest";

export class InputAutocomplete {
    /** @type {HTMLElement} */
    #hiddenInput
    /** @type {HTMLElement} */
    #input

    /** @type {string} */
    #label

    #request

    /** @type {Array} */
    #templateLabel

    /** @type {string} */
    #value

    /**
     *
     * @param input
     * @param label // si spécifié, indique la colonne a afficher dans le select
     * @param value
     * @param templateLabel
     * si spécifié, indique les colonnes a afficher dans le select
     * exemple si label/la valeur de la colonne n'est pas unique dans la table,
     * possibilité d'ajouter la valeur dune autre colonne pour différencier la selection
     * @param hiddenInput
     * @param request
     */
    constructor({ input, label, value, templateLabel = false, hiddenInput = false, request }) {
        this.#input = input;
        this.#hiddenInput = (hiddenInput)? this.#createHiddenInput() : hiddenInput;
        this.#label = label;
        this.#templateLabel = templateLabel;
        this.#value = value;
        this.#request = request
    }

    /**
     * Ajoute un input Hidden si specifié dans le constructeur
     * @returns {HTMLInputElement}
     */
    #createHiddenInput() {
        const hiddenInput = document.createElement("input");
        hiddenInput.type = "hidden";
        hiddenInput.name = this.#input.name + "_id"; // Ajoutez "Id" à la fin du nom de l'entrée pour le nom de l'élément caché
        this.#input.after(hiddenInput);
        return hiddenInput;
    }

    /**
     * Initialise le label du select et de l'input suivant le type de label parametré
     * si templateLabel defini
     * le select contient l'ensemble des colonnes spécifié
     * et l'input seulement le premiere element du tableau templateLabel
     * @param item
     * @param forInput
     * @returns {*}
     */
    #getLabel(item, forInput = false) {
        let label;
        if (this.#templateLabel) {
            label = this.#templateLabel(item);
        } else {
            label = [item[this.#label]];
        }
        return forInput ? label[0] : label.join(' - ');
    }


    /**
     *
     */
    setupAutocomplete() {
        const { url, requestData } = this.#request;

        $(this.#input).autocomplete({
            minLength: 3,
            delay: 300,
            source: (request, response) => {
                apiRequest(url, requestData(request.term), (data) => {

                    const items = data.map(item => ({
                            label: this.#getLabel(item, false),
                            value: item
                        })
                    );

                    response(items);

                });
            },
            select: (event, ui) => {

                $(this.#input).val(this.#getLabel(ui.item.value, true));
                $(this.#hiddenInput).val(ui.item.value[this.#value]);

                event.preventDefault();

                $(this.#input).trigger("inputChange", ui.item.value);
            }
        });


    }

}