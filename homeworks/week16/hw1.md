console 的輸出順序依序為：1 → 3 → 5 → 2 → 4 。
程式碼由上而下讀取時，首先 JS 會將任務包進 main() 函式，使 main 進入 call stack 的底端，接著 1、3、5 會在被放入執行任務的 call stack 後隨即執行，但使用 setTimeout 的 2、4 會先被從 call stack 中丟出到瀏覽器的執行環境中進行倒數，等到完成再回傳到 callback queue。
此時雖然倒數時長的參數是 0，但立刻完成倒數的任務被丟到 callback queue 以後，必須等待 call stack 清空以後才會被 event loop 丟回 call stack。
因此，在 callback queue 等待的 2 必須等到 1、3、5 執行完、main() 從 call stack 被移除後，才能回到 call stack 執行、而 4 又要等到 2 執行完之後才能進入 call stack 執行。

*註：我對於 JS 是如何使用 main() 包裝任務的運作原理還不太清楚，想請問助教或老師是否有推薦的文章可以幫助理解？簡單使用 js eventloop main() 等關鍵字搜尋後大多只會導回本週提供的影片，麻煩了。