/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./public/**/*.{php,html}", "./src/**/*.{html,js,vue}"],
  safelist: [
    "col-start-1",
    "col-start-2",
    "col-start-3",
    "col-start-4",
    "col-start-5",
    "col-start-6",
    "col-start-7",
  ],
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
