## 請找出三個課程裡面沒提到的 HTML 標籤並一一說明作用。
<strong>：用於強調標籤內的內容。
在瀏覽器中的視覺效果通常類似於會將文字變成粗體的 <b>，但是 <strong> 對 SEO 具有影響，可以確實讓搜尋引擎理解到標籤內的文字應該優先被讀取，所以一般推薦使用 <strong> 取代 <b>。
<cite>：用於標記標籤內的內容為某作品之標題的引用。
在瀏覽器中的視覺效果通常為斜體，可以用於針對引用內容做過設計的使用者，例如透過程式碼將所有 <cite> 標籤的內容在網頁最後以註腳的方式條列。
<map>：用於在圖片中指定特定的區域建立超連結，以使圖片達成電子地圖或目錄的效果。
在瀏覽器中將滑鼠移動到連結區域時會顯示事先指定的文字，<map> 透過 herf、title、shape 等參數設定圖片各區域（area）的顯示文字、範圍與連結網址。

## 請問什麼是盒模型（box model）
Box model 指使用 CSS 進行排版時，與指定標籤內容相關的區域，包含 Content（內容）、Padding（內邊距）、Border（邊框）、Margin（外邊距）四個部分。
這四個部分以 Content 為核心、由內而外互相影響：
Content 是 Box 內的文字、圖片、表格「實際」能夠作用的範圍，除非設定 box-sizeing 為 border-box，否則其餘三個區塊都以 Content 的外緣為邊界依序向外延伸。
Padding 是 Content 與 Border 之間的區域，透過設定 Padding 可以將 Content 與 Border 保持距離，形成「Box 內」排版上的留白效果。
Border 是 Padding 與 Margin 之間的區域，Border 以 Padding 的外緣為邊界延伸，通常透過設定不同的尺寸與顏色標記出區域的邊界，決定 Box 在「視覺上」的邊界在哪裡。
Margin是一個 Box model 的最外層，其由 Border 外緣為邊界延伸，決定 Box 與其它物件之間會預留多少距離，形成「Box外」排版上的留白效果。另外，透過調整 Margin 的尺寸，可以決定多個 Box-medal 之間彼此是否會產生重疊。
總結來說，Box model 四個部分涵蓋的範圍加總起來是其在排版時實際的影響範圍。

## 請問 display: inline, block 跟 inline-block 的差別是什麼？
Block 是 html 區塊元素標籤（例：div、ul li、p、h1）預設的 display 參數。
* 在此狀態下每個標籤自動佔據 「其內容高度*頁面總寬度」 的範圍。
* 在此狀態下即使將標籤設定了寬度也無法並排顯示標籤，將會自動換行。

Inline 是 html 行內元素標籤（例：span、a、imput、img）預設的 display 參數。
* 在此狀態下每個標籤的長寬根據其內容的多少自動調整，同時標籤會自動並排，但無法自動換行。
* 在此狀態下即使將標籤設定了高度或外邊距也不會影響到標籤實際所佔據的高度，外邊距或邊框可能會蓋住其它標籤的內容。

inline-block 性質為前兩者的綜合體。
* 在此狀態下可以手動設定標籤的寬高、並且能夠自動並排及自動換行。

## 請問 position: static, relative, absolute 跟 fixed 的差別是什麼？
Static 是 position 的預設參數，代表元素會以預設的規律被定位。
Relative 參數下，可透過 top、bottom、left、right 等屬性將元素自預設位置進行「視覺上的偏移」，但偏移後元素仍會佔據原本的空間，不會影響其他元素的位置。
Absolute 參數下，可透過 top、bottom、left、right 等屬性將元素將其自「上一個有定位的元素」為錨點進行「整個元素的偏移」，偏移後整個元素的位置會移動，會影響其他元素的位置。
* 上一個有定位的元素指其上層標籤中，最接近的「position 參數不為 static」的元素，若沒有找到，則將錨點自動定為 <body> （整個網頁）的左上角。
fixed 參數下，可透過 top、bottom、left、right 等屬性將元素將其定位在瀏覽器中的固定位置，元素將不會隨著視窗的移動而偏移，並且不會影響其他元素的位置。

參考資料：
[CSS教學-關於display:inline、block、inline-block的差別](https://ytclion.medium.com/css%E6%95%99%E5%AD%B8-%E9%97%9C%E6%96%BCdisplay-inline-inline-block-block%E7%9A%84%E5%B7%AE%E5%88%A5-1034f38eda82)
[深入理解 CSS Box Model ( 盒子模型 )](https://www.oxxostudio.tw/articles/202008/css-box-model.html)
[HTML 标签参考手册](https://www.w3school.com.cn/tags/index.asp)
[【Web】如何利用 HTML ＜map＞ Tag 來完成影像地圖設計 (上)](https://spicyboyd.blogspot.com/2018/06/web-html-map-tag.html)
[學習 CSS 版面配置](https://zh-tw.learnlayout.com/position.html)