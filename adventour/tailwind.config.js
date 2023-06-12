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
    extend: {
      animation: {
        shake: "shake 0.5s",
      },
      keyframes: {
        shake: {
          "0%, 100%": {
            transform: "translateX(0) rotate(0)",
          },
          "10%, 50%, 90%": {
            transform: "translateX(-4px)",
          },
          "20%, 60%": {
            transform: "translateX(4px)",
          },
        },
      },
    },
  },
  corePlugins: {
    aspectRatio: false,
  },
  plugins: [require("@tailwindcss/aspect-ratio")],
};
