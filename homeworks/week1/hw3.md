## 教你朋友 CLI

嗨，H0W哥。簡單來說，CLI 是一種一般人不會用到的操作系統，我們在 CLI 上會以輸入文字指令的方式跟電腦溝通，舉例來說，當你用指令「cd」可以切換到其他資料夾。這個指令的功能就跟你在電腦的視窗中點擊其他資料夾切換是一樣的，只是對沒有學習過如何操作 CLI 的人來說比較不直覺，所以我們發明了許多的圖形化介面（GUI），也就是你現在看我這封信時用的視窗，幫助大家可以更輕易使用電腦，看到這裡，你可能會想問，既然 GUI 這麼方便，為什麼還要用 CLI 呢？其實原因也很簡單：第一是 CLI 的介面比較節省電腦資源、第二是有許多比較專業的系統並沒有設計 GUI 介面，所以，即使現在都 2021 年了，你在電影裡看到有駭客登場的鏡頭時，他們還是得對著黑黑白白的 CLI 介面敲一些神秘的指令，唉。

至於你說想學怎麼使用 CLI 的話，首先就要從準備工具開始了。雖然電腦也有內建像是 Cmd 這種預設的 CLI 程式，但我還是建議你下載 Git Bash 或是 iTerm2 這類的 CLI 介面，他們功能比較多，介面也比較好看，這樣至少到時候你出錯誤時心情會好一點，ㄏㄏ。

下載安裝完之後，打開你的 CLI 就可以直接開始使用了。因為我也是剛學 CLI 不久的新手，所以我會建議你跟我一樣，在使用 CLI 時同時開著 CLI 常見指令的教學，例如[這個]( https://zh-tw.coderbridge.com/@MoreCoke/31ccfbee5ba042dda149e088ef7398ba)，這樣要查資料時就不用再特地搜尋。

這裡還是先跟你分享幾個最常用的基本指令（依我的理解 H0W哥你一定是果粉吧，如果是 Windows的話指令會有一些不同喔）：
* pwd，當你輸入時，電腦會告訴你，你人目前在檔案目錄中的哪個位置。
* ls，這個指令會列出你目前所在位置的檔案清單，可以搭配前面的 pwd 使用。
* cd，在這個指令的後面加上你想要去的資料夾，就可以切換到那裏，如果你要切換的資料夾就在你現在在的地方，可以直接輸入它的名稱就好，但如果不是的話，就得輸入完整的檔案路徑。
* man，當你不知道某個指令怎麼用的時候在它前面加上 man，就能得到它的使用說明，如果你想知道指令的進階用法也可以用它。

至於你想要做的功能，其實也滿簡單的，主要會用到的是 mkdir 跟 touch 兩個指令。
* 首先第一步，打開 CLI，切換到你要開資料夾的位置。
* 第二步，我們使用 mkdir 這個指令創立資料夾，你說資料夾要叫「wifi」的話，就打：
```mkdir wifi```
* 接著，我們切進 wifi 這個資料夾裡，使用：
```cd wifi```
* 然後，我們就可以用 touch 這個指令建立 afu.js 這個檔案了，記得要寫上副檔名：
```touch afu.js```
* 最後，你可以用電腦的 GUI 介面打開資料夾確認一下操作有沒有成功。

CLI 的教學就到這邊，先這樣啦，ㄅㄅ

參考資料：
[CLI 常用指令整理 by MoreCoke]https://zh-tw.coderbridge.com/@MoreCoke/31ccfbee5ba042dda149e088ef7398ba