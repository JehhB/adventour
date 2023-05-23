const { defineConfig } = require("@vue/cli-service");
module.exports = defineConfig({
  pages: {
    index: {
      entry: "src/main.ts",
      template: "public/index.php",
      filename: "index.php",
    },
  },
  publicPath: "./",
  outputDir: "html",
  assetsDir: "dist",
  transpileDependencies: true,
  runtimeCompiler: true,
  configureWebpack: {
    output: {
      filename: "dist/js/[name].[contenthash:8].js",
      chunkFilename: "dist/js/[name].[contenthash:8].js",
    },
  },
  css: {
    extract: true,
  },
});
