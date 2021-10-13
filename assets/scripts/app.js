//
// assets/viewer.js
//

// any CSS you import will output into a single css file (app.css in this case)
import '../styles/app.scss';

const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');


window.addEventListener('load', () => {
    console.log("KoureiFes_Quiz");
    $('[data-toggle="popover"]').popover();
});
