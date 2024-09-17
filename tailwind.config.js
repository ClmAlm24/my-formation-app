/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js}"],
  theme: {
    extend: {
      colors: {
        primary: '#381D2A',          // Rouge-marron sombre
        secondary: '#3E6990',        // Bleu-gris moyen
        darkAccent: '#000000',       // Noir
        lightAccent: '#FFFFFF',      // Blanc
        primaryLight: '#5C2E3D',     // Version plus claire de la couleur principale
        secondaryLight: '#4A7DA6',   // Version plus claire de la couleur secondaire
        darkGray: '#1A1A1A',         // Gris très foncé pour les accents
        lightGray: '#F2F2F2',        // Gris très clair pour les tons doux
      },
    },
  },
  plugins: [],
}
