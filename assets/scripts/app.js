//
// assets/viewer.js
//

// any CSS you import will output into a single css file (app.css in this case)
import '../styles/app.scss';
import { pushPuzzle } from './evaluation';
import { initialize } from './initialize';
import { showAnswer } from './popover';

window.addEventListener('load', () => {

    // ウィンドウ初期化
    initialize();

    // パズルボタンにイベントリスナを当てる
    const buttons = document.querySelectorAll(".puzzlebutton");
    buttons.forEach((button) => {
        button.addEventListener('click', (event) => {
            // ボタンのクリック状態を取得・設定
            const isClicked = button.getAttribute("data-pushed") == "true";
            if (isClicked) return;
            button.setAttribute("data-pushed", "true");

            // クリックされたボタンの色を変える
            button.style.backgroundColor = button.getAttribute("data-color");

            // パズル評価関数を呼び出す
            if (pushPuzzle(button.getAttribute("data-button-id"))) {
                // パズルが解けたら解答を表示
                setTimeout(() => {
                    showAnswer();
                }, 200);
            }
        });
    });
});

