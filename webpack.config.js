
const defaults = require('@wordpress/scripts/config/webpack.config');

// var path = require('path');
// module.exports = {
//   ...defaults,
//   externals: {
//     react: 'React',
//     'react-dom': 'ReactDOM',
//   },
//   output: {
//     filename: "pro_index.js", 
//     path: path.resolve(__dirname, "./build/"),
//   },
// }; 

var path = require('path');
module.exports = {
  ...defaults,
  entry: "./src/pro_index.js",
  externals: {
    react: 'React',
    'react-dom': 'ReactDOM',
  },
  output: {
    filename: "pro_index.js", 
    path: path.resolve(__dirname, "./build/"),
  },
};