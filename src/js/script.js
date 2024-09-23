const loginBtn = document.getElementById('loginBtn');
const registerBtn = document.getElementById('registerBtn');
const connexionSection = document.getElementById('connexionSection');
const inscriptionSection = document.getElementById('inscriptionSection');

loginBtn.addEventListener('click', () => {
    connexionSection.classList.remove('hidden');
    inscriptionSection.classList.add('hidden');
    loginBtn.classList.add('text-primary');
    registerBtn.classList.remove('text-primary');
    registerBtn.classList.add('text-secondary');
});

registerBtn.addEventListener('click', () => {
    inscriptionSection.classList.remove('hidden');
    connexionSection.classList.add('hidden');
    registerBtn.classList.add('btn')
    registerBtn.classList.add('text-primary');
    loginBtn.classList.remove('text-primary');
    loginBtn.classList.add('text-secondary');
});


// Import des modules nécessaires
import { Ripple, Input, initTWE } from 'tw-elements';

// Initialisation de tw-elements avec les composants requis
initTWE({ Ripple, Input });

