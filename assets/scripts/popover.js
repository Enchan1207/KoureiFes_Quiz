//
// 解答ポップオーバー
//

/**
 * 解答パネル (#Answer) を表示します。
 */
export const showAnswer = () => {
    const answerPanel = document.getElementById("Answer");

    if (!answerPanel.classList.contains("show")) {
        answerPanel.classList.add("show");
    }
}
