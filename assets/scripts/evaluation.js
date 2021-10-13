//
// パズル評価関数
//

/**
 * パズルを評価します。
 * @param {Number} buttonID 押されたボタンのID。
 * @returns {boolean} パズルの評価結果。
 */
export const pushPuzzle = (buttonID) => {
    const inputPanel = document.getElementById("Input");

    // 評価バッファを呼び出し、「これまでに押されているボタン」を取得
    const evalBufferRaw = inputPanel.getAttribute("data-buffer");
    const evalBuffer = evalBufferRaw != "" ? evalBufferRaw.split(",") : [];

    // 今回押したボタンを追加
    evalBuffer.push(buttonID);
    inputPanel.setAttribute("data-buffer", evalBuffer.join(","));

    // 解答を読み込み、バッファと比較
    const answerBufferRaw = inputPanel.getAttribute("data-answer");

    return answerBufferRaw == evalBuffer.join(",");
}
