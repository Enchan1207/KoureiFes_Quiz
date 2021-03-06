//
// 初期化処理
//
import { initButton } from './button';

export const initialize = () => {

    // リサイズ時に高さを再設定
    setWindowHeight();
    window.onresize = () =>{
        console.log("Resize");
        setWindowHeight();
    }

    // パズルボタン初期化
    const buttons = document.querySelectorAll(".puzzlebutton");
    buttons.forEach(initButton);

};

/**
 * ウィンドウ(#wrapper)の高さを設定します。
 * @param {Number|null} height 設定する高さ。nullを設定するとwindow.innerHeightが適用されます。
 */
const setWindowHeight = (height = null) => {
    const _height = height ?? window.innerHeight;
    const wrapper = document.getElementById('wrapper');

    wrapper.style.height = `${_height}px`;
}
