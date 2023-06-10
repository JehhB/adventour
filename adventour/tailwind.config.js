/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./public/**/*.{php,html}", "./src/**/*.{html,js,vue}"],
  theme: {
    fontFamily: {
      sans: ["Inter", "sans-serif"],
      text: ['"Didact Gothic"', "Inter", "sans-serif"],
      cursive: ['"Hanalei Fill"', "cursive"],
      heading: ["Athiti", "Inter", "sans-serif"],
    },
  },
  corePlugins: {
    aspectRatio: false,
  },
  plugins: [require("@tailwindcss/aspect-ratio")],
};
