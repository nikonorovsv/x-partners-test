'use strict';

const webpack = require('webpack')
const fs = require('fs');
const path = require('path')
const MiniCssExtractPlugin = require("mini-css-extract-plugin")
const { VueLoaderPlugin } = require("vue-loader")

const baseDir = fs.realpathSync(process.cwd())

let config = {
  externals: {},
  entry: [
    path.resolve(baseDir, 'src/js/app.js'),
    path.resolve(baseDir, 'src/scss/app.scss'),
  ],
  output: {
    filename: 'bundle.js',
    path: path.resolve(baseDir, '../assets'),
    publicPath: '/js'
  },
  resolve: {
    alias: {
      components: path.resolve(baseDir, 'js/components'),
      mixins: path.resolve(baseDir, 'js/mixins'),
      libs: path.resolve(baseDir, 'js/libs'),
      store: path.resolve(baseDir, 'js/store'),
    },
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /(node_modules|bower_components)/,
        use: [
          { loader: 'babel-loader' },
          // { loader: 'eslint-loader' }
        ]
      },
      {
        test: /\.(css|scss)$/,
        use: [
          { loader: MiniCssExtractPlugin.loader },
          { loader: 'css-loader', options: { sourceMap: true } },
          { loader: 'resolve-url-loader' },
          { loader: 'postcss-loader' },
          {
            loader: 'sass-loader',
            options: {
              sourceMap: true,
            }
          }
        ]
      },
      {
        test: /\.(png|jpg|gif|svg)$/,
        use: [
          {
            loader: 'file-loader',
            options: {
              name: '[name].[ext]',
              outputPath: 'images'
            }
          }
        ]
      },
      {
        test: /\.(ttf|eot|woff|woff2)$/,
        use: [
          {
            loader: 'file-loader',
            options: {
              name: '[name].[ext]',
              outputPath: 'fonts'
            }
          }
        ]
      },
      { test: /\.vue$/, use: "vue-loader" },
    ]
  },
  // resolve: {
  //   alias: {
  //     '@': path.resolve(__dirname, 'node_modules'),
  //   }
  // },
  plugins: [
    new webpack.DefinePlugin({
      AJAX_URL: JSON.stringify('/wp-admin/admin-ajax.php'),
    }),
    new webpack.ProvidePlugin({
      google: 'google',
      'window.google': 'google'
    }),
    new MiniCssExtractPlugin({
      filename: 'bundle.css'
    }),
    new VueLoaderPlugin(),
  ]
}

module.exports = (env, argv) => {
  if (argv.mode === 'development') {
    config = {
      ...config,
      watch: true,
      watchOptions: {
        aggregateTimeout: 100
      },
      devtool: 'inline-cheap-module-source-map',
      devServer: {
        overlay: true
      }
    }
  }

  if (argv.mode === 'production') {
    config = {
      ...config,
      optimization: {
        minimize: true
      }
    }
  }

  return config
}