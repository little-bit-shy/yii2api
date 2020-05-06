process.env.NODE_ENV = 'development';
const webpack = require('webpack');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const merge = require('webpack-merge');
const webpackBaseConfig = require('./webpack.base.config.js');
const fs = require('fs');
const package = require('../package.json');
const config = require('./config');

module.exports = merge(webpackBaseConfig, {
    devServer: {
        proxy: {
            '/api': {
                target: config.target,
                changeOrigin: true,
                pathRewrite: {'^/api': '/'}
            }
        },
        contentBase: "/",
        port: 80
    },
    devtool: '#source-map',
    output: {
        publicPath: '/',
        filename: '[name].js',
        chunkFilename: '[name].chunk.js'
    },
    //module: {
    //    rules: [
    //        {
    //            test: /\.ejs$/,
    //            use: [
    //                {
    //                    loader: 'html-loader', // 使用 html-loader 处理图片资源的引用
    //                    options: {
    //                        attrs: ['img:src', 'img:data-src']
    //                    }
    //                }
    //            ]
    //        }
    //    ]
    //},
    plugins: [
        new webpack.DefinePlugin({
            'process.env.NODE_ENV': '"development"'
        }),
        new ExtractTextPlugin({
            filename: '[name].css',
            allChunks: true
        }),
        new webpack.optimize.CommonsChunkPlugin({
            name: ['vender-exten', 'vender-base'],
            minChunks: Infinity
        }),
        new HtmlWebpackPlugin({
            title: 'iView admin v' + package.version,
            favicon: './favicon.ico',
            filename: './index.html',
            template: './src/template/index.ejs',
            inject: false
        }),
        new CopyWebpackPlugin([
            {
                from: 'src/views/main-components/theme-switch/theme'
            },
            {
                from: 'src/views/my-components/text-editor/tinymce'
            }
        ], {
            ignore: [
                'text-editor.vue'
            ]
        })
    ]
});
