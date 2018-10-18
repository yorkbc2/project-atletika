module.exports = {
    entry: [
        "./assets/jsx/index.js"
    ],
    output: {
        path: __dirname + "/assets/js",
        filename: "filter-products.bundle.js",
        publicPath: "/"
    },
    module: {
        rules: [
            {
                test: /\.(js|jsx)$/,
                exclude: /node_modules/,
                use: ["babel-loader"]
            }
        ]
    },
    watch: true
}