const webpack = require("webpack");
const path = require("path");
const ExtractTextPlugin = require("extract-text-webpack-plugin");
const BrowserSyncPlugin = require("browser-sync-webpack-plugin");

let config = {
  entry: {
    main: ["./js/theme.js", "./scss/theme.scss"],
  },
  output: {
    path: path.resolve(__dirname, "../assets/js"),
    filename: "theme.js",
  },
  module: {
    rules: [
      {
        test: /\.js/,
        loader: "babel-loader",
      },
      {
        test: /\.scss$/,
        use: ExtractTextPlugin.extract({
          fallback: "style-loader",
          use: [
            {
              loader: "css-loader",
              options: {
                minimize: true,
              },
            },
            "postcss-loader",
            "sass-loader",
          ],
        }),
      },
      {
        test: /.(png|woff(2)?|eot|ttf|svg|gif|jpg|jpeg)(\?[a-z0-9=\.]+)?$/,
        use: [
          {
            loader: "file-loader",
            options: {
              name: "../css/[hash].[ext]",
            },
          },
        ],
      },
      {
        test: /\.css$/,
        use: ["style-loader", "css-loader", "postcss-loader"],
      },
    ],
  },
  externals: {
    $: "$",
    jquery: "jQuery",
  },
  plugins: [
    new ExtractTextPlugin(path.join("..", "css", "theme.css")),
    new BrowserSyncPlugin({
      host: "localhost",
      port: 3000,
      proxy: "http://budweiser-drupal8-app.lndo.site/", // config local site
    }),
  ],
};

if (process.env.NODE_ENV === "production") {
  config.plugins.push(
    new webpack.optimize.UglifyJsPlugin({
      sourceMap: false,
      compress: {
        sequences: true,
        conditionals: true,
        booleans: true,
        if_return: true,
        join_vars: true,
        drop_console: true,
      },
      output: {
        comments: false,
      },
      minimize: true,
    })
  );
}

module.exports = config;
