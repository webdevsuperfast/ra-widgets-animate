const esbuild = require("esbuild");

const isWatch = process.argv.includes("--watch");

const builds = [
  // USAL JS
  {
    entryPoints: ["node_modules/usal/usal.min.js"],
    outfile: "public/js/usal.js",
    minify: false,
  },
  {
    entryPoints: ["node_modules/usal/usal.min.js"],
    outfile: "public/js/usal.min.js",
    minify: true,
  },
  // RAWA Admin CSS
  {
    entryPoints: ["develop/admin/css/rawa-admin.css"],
    outfile: "admin/css/rawa-admin.css",
    minify: false,
  },
  {
    entryPoints: ["develop/admin/css/rawa-admin.css"],
    outfile: "admin/css/rawa-admin.min.css",
    minify: true,
  },
  // RAWA Public JS
  {
    entryPoints: ["develop/public/js/rawa.js"],
    outfile: "public/js/rawa.js",
    minify: false,
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
    minify: false,
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
    minify: false,
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
    minify: false,
  },
  {
    entryPoints: ["develop/admin/js/siteorigin-admin.js"],
    outfile: "admin/js/siteorigin-admin.min.js",
    minify: true,
  },
  // Gutenberg Admin JS
  {
    entryPoints: ["develop/admin/js/gutenberg-admin.js"],
    outfile: "admin/js/gutenberg-admin.js",
    minify: false,
    loader: {
      ".js": "jsx",
    },
  },
  {
    entryPoints: ["develop/admin/js/gutenberg-admin.js"],
    outfile: "admin/js/gutenberg-admin.min.js",
    minify: true,
    loader: {
      ".js": "jsx",
    },
  },
];

async function build() {
  for (const config of builds) {
    await esbuild.build(config);
  }
  console.log("Build completed");
}

function watch() {
  console.log("Watch mode not implemented");
}

if (isWatch) {
  watch();
} else {
  build().catch(console.error);
}
