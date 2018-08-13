const path = require('path');
const webpack = require('webpack');
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');

module.exports = env => {
    const config = {
        entry: {
            'admin/core': './src/js/admin/core.js',
            'public/core': './src/js/public/core.js',
        },
        output: {
            filename: '[name].js',
            path: path.resolve(__dirname, 'js'),
        },
        module: {
            rules: [
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env'],
                        },
                    },
                },
            ],
        },
    };

    return config;
};
