import { submitButton } from "./class/SubmitButton";
import {Validation} from "./class/Validation";




document.querySelectorAll('.js-validation').forEach(elem => {
    const instance = new Validation(elem);
    submitButton.init(instance);
});
