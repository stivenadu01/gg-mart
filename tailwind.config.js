/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/**/*.{php,html,js}"
  ],
  safelist: [
    {
      pattern: /^(m|ml|mr|mt|mb)-(14|16|64|px)$/,
    },
  ],
  theme: {
    extend: {
      colors: {
        primary: "#1E454C",   // Hijau Tua
        secondary: "#D4862E", // Oranye
        accent: "#4C7A4A",    // Hijau Muda
        alt: "#174D59",       // Biru kehijauan
        neutral: "#333333",   // Warna teks utama
      },
    },
  },
  plugins: [],
}

