//
// ボタン周りの処理
//
import { evaluatePuzzle } from './evaluation';
import { showAnswer } from './popover';

/**
 * ボタンを初期化します。
 * @param {Element} buttonElement 対象のボタン。
 */
export const initButton = (buttonElement) => {
    const clickEvent = (event) => {
        // ボタンのクリック状態を取得・設定
        const isClicked = buttonElement.getAttribute("data-pushed") == "true";
        if (isClicked) return;
        buttonElement.setAttribute("data-pushed", "true");

        // クリックされたボタンの色を変える
        buttonElement.style.backgroundColor = buttonElement.getAttribute("data-color");

        // パズル評価関数を呼び出す
        const result = evaluatePuzzle(buttonElement.getAttribute("data-button-id"));
        if (result == 1) {
            // パズルが解けたら解答を表示
            setTimeout(() => {
                showAnswer();
            }, 200);
            return;
        }
        if (result == 0) {
            // 不正解ならボタンをリセット
            setTimeout(() => {
                const buttons = document.querySelectorAll(".puzzlebutton");
                buttons.forEach(resetButton);
            }, 400);

            // 解答バッファをクリア
            const inputPanel = document.getElementById("Input");
            inputPanel.setAttribute("data-buffer", "");
        }
    }
    
    buttonElement.removeEventListener('click', clickEvent);
    buttonElement.addEventListener('click', clickEvent);
};

/**
 * ボタンの押下状態をリセットします。ボタンを押した履歴はリセットされません。
 * @param {Element} buttonElement 対象のボタン。
 */
export const resetButton = (buttonElement) => {
    buttonElement.style.backgroundColor = "unset";
    buttonElement.setAttribute("data-pushed", "false");
}
