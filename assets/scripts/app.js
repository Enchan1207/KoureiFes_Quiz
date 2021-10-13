//
// assets/viewer.js
//

// any CSS you import will output into a single css file (app.css in this case)
import '../styles/app.scss';
import { initialize } from './initialize';
import { showAnswer } from './popover';

window.addEventListener('load', () => {

    initialize();

});

