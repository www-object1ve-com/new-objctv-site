const path = require('path');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

const asbolutePath = path.resolve(__dirname, 'dist/js');

const homeConfig = {
    entry: ['./assets/js/home.js'],
    output: {
        filename: 'home.min.js',
        path: asbolutePath,
    },
    plugins: [
        new CleanWebpackPlugin({
            cleanOnceBeforeBuildPatterns: ['home.min.js'],
        }),
    ],
};

const singleConfig = {
    entry: ['./assets/js/single.js'],
    output: {
        filename: 'single.min.js',
        path: asbolutePath,
    }
};

module.exports = [
    homeConfig, singleConfig,
];