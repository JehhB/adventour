<!-- File for global css and script -->
<style>
  @import url("https://fonts.googleapis.com/css2?family=Bahiana&family=Didact+Gothic&family=Hanalei+Fill&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap");

  *,
  *::after,
  *::before {
    box-sizing: border-box;
  }

  [debug] * {
    outline: 1px solid red;
  }

  [debug] svg * {
    outline: transparent;
  }

  :root {
    --fg-color: #2d2d2d;
    --bg-color: #fcfcfc;
    --accent-color: #395f1c;

    --gray-50: #fafafa;
    --gray-100: #f5f5f5;
    --gray-200: #e5e5e5;
    --gray-300: #d4d4d4;
    --gray-400: #a3a3a3;
    --gray-500: #737373;
    --gray-600: #525252;
    --gray-700: #404040;
    --gray-800: #262626;
    --gray-900: #171717;
    --gray-950: #0a0a0a;

    --col1: calc(100% / 12 * 1);
    --col2: calc(100% / 12 * 2);
    --col3: calc(100% / 12 * 3);
    --col4: calc(100% / 12 * 4);
    --col5: calc(100% / 12 * 5);
    --col6: calc(100% / 12 * 6);
    --col7: calc(100% / 12 * 7);
    --col8: calc(100% / 12 * 8);
    --col9: calc(100% / 12 * 9);
    --col10: calc(100% / 12 * 10);
    --col11: calc(100% / 12 * 11);
    --col12: calc(100% / 12 * 12);

    --bounce-out: cubic-bezier(0.36, -0.01, 0.5, 1.38);
  }

  body {
    margin: 0px;
    background-color: var(--bg-color);
    color: var(--fg-color);
    font-family: "Didact Gothic", "Inter", sans-serif;
  }

  h1,
  h2,
  h3,
  h4,
  h5,
  h6,
  ul,
  ol,
  p {
    margin: 0;
  }

  h1,
  h2,
  h3,
  h4 {
    font-family: "Bahiana", cursive;
  }

  .container {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    width: 1140px;
    margin: 0 auto;
  }

  @media screen and (max-width: 1199px) {
    .container {
      width: 960px;
    }
  }

  @media screen and (max-width: 991px) {
    .container {
      width: 720px;
    }
  }

  @media screen and (max-width: 768px) {
    .container {
      width: 540px;
    }
  }

  @media screen and (max-width: 576px) {
    .container {
      width: 100%;
    }
  }

  .block-loader {
    background-color: var(--gray-300);
    position: relative;
    overflow: hidden;
  }

  .block-loader::after {
    content: "";
    position: absolute;
    left: -45%;
    height: 100%;
    width: 45%;
    background-image: linear-gradient(to left,
        #fbfbfb0d,
        #fbfbfb4d,
        #fbfbfb99,
        #fbfbfb4d,
        #fbfbfb0d);
    animation: loading 1s infinite ease-in-out;
  }

  @keyframes loading {
    0% {
      left: -45%;
    }

    100% {
      left: 100%;
    }
  }

  @keyframes slideUp {
    0% {
      opacity: 0;
      transform: translateY(2rem);
    }

    100% {
      opacity: 1;
      transform: inherit;
    }
  }

  @keyframes slideDown {
    0% {
      opacity: 0;
      transform: translateY(-2rem);
    }

    100% {
      opacity: 1;
      transform: inherit;
    }
  }

  @keyframes zoomIn {
    0% {
      opacity: 0;
      transform: scale(0.5);
    }

    100% {
      opacity: 1;
      transform: scale(1);
    }
  }

  @keyframes fadeIn {
    0% {
      opacity: 0;
    }

    100% {
      opacity: 1;
    }
  }

  @keyframes floating {
    0% {
      opacity: 1;
      transform: translateY(0);
    }

    50% {
      transform: translateY(-0.5rem);
    }

    100% {
      transform: translateY(0);
    }
  }
</style>
