/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./public/**/*.{php,html}", "./src/**/*.{html,js,vue}"],
  theme: {
    fontFamily: {
      sans: ["Inter", "sans-serif"],
      text: ['"Didact Gothic"', "Inter", "sans-serif"],
      cursive: ['"Hanalei Fill"', "cursive"],
    },
  },
  plugins: [],
};
