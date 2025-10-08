/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    // Add other paths as needed
  ],
  darkMode: 'class',  // This is the key line—add it if missing
  theme: {
    extend: {},
  },
  plugins: [],
}