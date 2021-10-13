//
// 解答ポップオーバー
//

/**
 * 解答パネル (#Answer) を表示します。
 */
export const showAnswer = () => {

    // CAUTION!! クソ実装!! CAUTION!!
    // この関数には多数のクソ実装が含まれています。

    // パネルを表示
    const answerPanel = document.getElementById("Answer");

    if (!answerPanel.classList.contains("show")) {
        answerPanel.classList.add("show");
    }

    // 解答の文字列を表示
    setTimeout(() => {
        // data-contentに逃がしておかないとLINEとかに貼り付けるだけで答えがバレる
        const answerContentElement = document.querySelector("#Answer h5");
        const answerContent = answerContentElement.getAttribute("data-content");

        let index = 0;
        const _int = setInterval(() => {
            answerContentElement.innerText = answerContentElement.innerText + answerContent[index];

            index++;
            if (index >= answerContent.length) {
                clearInterval(_int);
            }
        }, 25);
    }, 100);

}
