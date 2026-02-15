const esbuild = require("esbuild");

const isWatch = process.argv.includes("--watch");

const builds = [
  // USAL JS
  {
    entryPoints: ["node_modules/usal/usal.min.js"],
    outfile: "public/js/usal.min.js",
    minify: true,
  },
  // RAWA Admin CSS
  {
    entryPoints: ["develop/admin/css/rawa-admin.css"],
    outfile: "admin/css/rawa-admin.css",
    minify: true,
  },
  // RAWA Public JS
  {
    entryPoints: ["develop/public/js/rawa.js"],
    outfile: "public/js/rawa.js",
    minify: true,
  },
  {
    entryPoints: ["develop/public/js/rawa.js"],
    outfile: "public/js/rawa.min.js",
    minify: true,
  },
  // RAWA Admin JS
  {
    entryPoints: ["develop/admin/js/rawa-admin.js"],
    outfile: "admin/js/rawa-admin.js",
    minify: true,
  },
  {
    entryPoints: ["develop/admin/js/rawa-admin.js"],
    outfile: "admin/js/rawa-admin.min.js",
    minify: true,
  },
  // RAWA Settings JS
  {
    entryPoints: ["develop/admin/js/rawa-settings.js"],
    outfile: "admin/js/rawa-settings.js",
    minify: true,
  },
  {
    entryPoints: ["develop/admin/js/rawa-settings.js"],
    outfile: "admin/js/rawa-settings.min.js",
    minify: true,
  },
  // SiteOrigin Admin JS
  {
    entryPoints: ["develop/admin/js/siteorigin-admin.js"],
    outfile: "admin/js/siteorigin-admin.js",
    minify: true,
  },
  {
    entryPoints: ["develop/admin/js/siteorigin-admin.js"],
    outfile: "admin/js/siteorigin-admin.min.js",
    minify: true,
  },
];

async function build() {
  for (const config of builds) {
    await esbuild.build(config);
  }
  console.log("Build completed");
}

async function watch() {
  const contexts = [];
  for (const config of builds) {
    const ctx = await esbuild.context(config);
    await ctx.watch();
    contexts.push(ctx);
  }
  console.log("Watching for changes...");
}

if (isWatch) {
  watch();
} else {
  build();
}
