import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import fg from "fast-glob";

// https://vitejs.dev/config/
export default defineConfig((opt) => {
  return {
    plugins: [
      vue(),
      {
        name: "watch-external", // https://stackoverflow.com/questions/63373804/rollup-watch-include-directory/63548394#63548394
        async buildStart() {
          const files = await fg(["src/**/*", "public/**/{*,.*}"]);
          for (let file of files) {
            this.addWatchFile(file);
          }
        },
      },
    ],
    base: "./",
    build: {
      outDir: "html",
      rollupOptions: {
        output: {
          entryFileNames: `dist/[name].js`,
          chunkFileNames: `dist/[name].js`,
          assetFileNames: `dist/[name].[ext]`,
        },
        input: "src/main.ts",
      },
    },
  };
});
