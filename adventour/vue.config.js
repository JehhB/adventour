const { defineConfig } = require("@vue/cli-service");
const { minify } = require("html-minifier");

module.exports = defineConfig({
  pages: {
    index: {
      entry: "src/index.ts",
      template: "public/index.php",
      filename: "index.php",
    },
    search: {
      entry: "src/search.ts",
      template: "public/search.php",
      filename: "search.php",
    },
    hotel: {
      entry: "src/hotel.ts",
      template: "public/hotel.php",
      filename: "hotel.php",
    },
    event: {
      entry: "src/event.ts",
      template: "public/event.php",
      filename: "event.php",
    },
    place: {
      entry: "src/place.ts",
      template: "public/place.php",
      filename: "place.php",
    },
    login: {
      entry: "src/login.ts",
      template: "public/login.php",
      filename: "login.php",
    },
    signin: {
      entry: "src/signin.ts",
      template: "public/signin.php",
      filename: "signin.php",
    },
    changePassword: {
      entry: "src/changePassword.ts",
      template: "public/change-password.php",
      filename: "change-password.php",
    },
  },
  publicPath: "./",
  outputDir: "html",
  assetsDir: "dist",
  transpileDependencies: true,
  productionSourceMap: false,
  runtimeCompiler: true,
  configureWebpack: {
    output: {
      filename: "dist/js/[name].[contenthash:8].js",
      chunkFilename: "dist/js/[name].[contenthash:8].js",
      clean: process.env.NODE_ENV === "production",
    },
  },
  chainWebpack: (config) => {
    config.plugin("copy").tap((args) => {
      args[0].patterns[0].transform = (input, path) => {
        if (
          process.env.NODE_ENV === "production" &&
          /lib\/views\/.*?\.php$/.test(path)
        ) {
          return minify(input.toString(), {
            collapseWhitespace: true,
            minifyCSS: true,
            minifyJS: true,
            removeComments: true,
            continueOnParseError: true,
            sortAttribues: true,
            sortClassName: true,
            removeRedundantAttributes: true,
          });
        }
        return input;
      };

      return args;
    });
  },
  css: {
    extract: true,
  },
});
