import apiRequest from "../api/apiRequest";
export class InputAutocomplete {
    /** @type {HTMLElement} */
    #hiddenInput
    /** @type {HTMLElement} */
    #input

    /** @type {string | array} */
    #label

    #request
    /** @type {string} */
    #value

    /**
     *
     * @param input
     * @param label
     * @param value
     * @param hiddenInput
     * @param request
     */
    constructor({input, label, value, hiddenInput = false, request}) {
        this.#input = input;
        this.#hiddenInput = hiddenInput || this.#createHiddenInput();
        this.#label = label;
        this.#value = value;
        this.#request = request
    }

    /**
     *
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
                            label: item[this.#label],
                            value: item[this.#value]
                        })
                    );

                    response(items);

                });
            },
            select: (event, ui) => {
                $(this.#input).val(ui.item.label);
                $(this.#hiddenInput).val(ui.item.value);

                event.preventDefault();
            }
        });


    }

}