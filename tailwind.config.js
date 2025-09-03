/** @type {import('tailwindcss').Config} */
export default {
  content: [
    // Gunakan pola ini untuk memindai semua file .blade.php
    "./resources/views/**/*.blade.php",
    
    // Pola ini sudah benar
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};