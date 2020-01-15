module.exports = {
  pluginOptions: {
    i18n: {
      locale: "en",
      fallbackLocale: "en",
      localeDir: "locales",
      enableInSFC: false
    }
  },
  devServer: {
    port: 8010,
    proxy: {
      "/cryptoBoom": {
        target: "http://127.0.0.1:8080"
      }
    }
  }
};
