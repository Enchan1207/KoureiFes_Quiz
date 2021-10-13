//
// パズル評価関数
//

/**
 * パズルを評価します。
 * @param {Number} buttonID 押されたボタンのID。
 * @returns {Number} パズルの評価結果。 1:正解 0:不正解 -1:まだ押せるボタンがある
 */
export const evaluatePuzzle = (buttonID) => {
    const inputPanel = document.getElementById("Input");

    // 評価バッファを呼び出し、「これまでに押されているボタン」を取得
    const evalBufferRaw = inputPanel.getAttribute("data-buffer");
    const evalBuffer = evalBufferRaw != "" ? evalBufferRaw.split(",") : [];

    // 今回押したボタンを追加
    evalBuffer.push(buttonID);
    inputPanel.setAttribute("data-buffer", evalBuffer.join(","));

    // 解答を読み込み
    const answerBufferRaw = inputPanel.getAttribute("data-answer");
    const answerBuffer = answerBufferRaw.split(",");

    // バッファと比較
    if(answerBufferRaw == evalBuffer.join(",")){
        return 1;
    }

    // 全部押してれば不正解
    if(evalBuffer.length == answerBuffer.length){
        return 0;
    }

    return -1;
}
