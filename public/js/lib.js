function toggleVisibility() {

    const button = document.getElementById('Visibility');

    const input = document.getElementById('Password');

    button.classList.toggle('visibility-off-icon');
    button.classList.toggle('visibility-icon');

    // Basculer le type de l'input de mot de passe
    if (input.type === 'password') {
        input.type = 'text';
    } else {
        input.type = 'password';
    }
}

function getNewPassword() {
    const inputPassword = document.getElementById('Password');
    const motDePasseAleatoire = generatePassword();

    inputPassword.value = motDePasseAleatoire;

}
function generatePassword() {

    const minuscule = "abcdefghijklmnopqrstuvwxyz";
    const majuscule = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    const nombre = "0123456789";
    const special = "!?:_-*#&%+";

    let password = "";

    password += minuscule.charAt(Math.floor(Math.random() * minuscule.length));
    password += majuscule.charAt(Math.floor(Math.random() * majuscule.length));
    password += nombre.charAt(Math.floor(Math.random() * nombre.length));
    password += special.charAt(Math.floor(Math.random() * special.length));

    const longueurRestante = 12 - 4;
    const carateres = minuscule + majuscule + nombre + special;

    for (let i = 0; i < longueurRestante; i++) {
        password += carateres.charAt(Math.floor(Math.random() * carateres.length));
    }

    password = password.split('').sort(() => Math.random() - 0.5).join('');

    return password;
}