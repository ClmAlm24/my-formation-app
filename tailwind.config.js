/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./src/**/*.{html,js}'],
  theme: {
    extend: {
      colors: {
        primary: '#381D2A',
        secondary: '#3E6990',
        darkAccent: '#000000',
        lightAccent: '#FFFFFF',
        primaryLight: '#5C2E3D',
        secondaryLight: '#4A7DA6',
        darkGray: '#1A1A1A',
        lightGray: '#F2F2F2',
        scooter: '#2eb9db',
        iceCold: '#9ee9f4',
        viking: '#67bdd5',
        astral: '#2f8ea1',
        shakespeare: '#4bb2cc',
        pelorous: '#3da5b9',
        malibu: '#78e5fc',
        bostonBlue: '#3094b5',
        pictonBlue: '#3ccce4',
        pictonBlue2: '#34c4f4' // Notez que les clés de couleur doivent être uniques
      },
    },
  },
  plugins: [],
}
