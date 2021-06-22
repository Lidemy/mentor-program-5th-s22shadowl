## 什麼是 Ajax？
Ajax 是一種非同步的資料交換技術，其以 Javascript 為執行語言、透過 XML 或 JSON 等格式向伺服器送出請求並取得回應。

## 用 Ajax 與我們用表單送出資料的差別在哪？
相較於一般資料交換，Ajax 的最大特點在於可以透過非同步的方式加快網頁的執行效率，因為其在送出請求後，不需再花費時間等待伺服器的回應，而可以在這段期間繼續進行瀏覽或其他動作，也不必不斷重新整理網頁，伺服器的回應會以即時載入的方式出現在頁面中。

## JSONP 是什麼？
JSONP 是透過 HTML 中的 <script> 標籤，繞過瀏覽器進行資料交換時同源政策限制的手法，屬於 CORS 跨來源請求的方法之一。
其具體執行方式是在雙方約定好請求與回傳格式後，透過 <script> 標籤中的 src 將 url 的回傳內容引入網頁中，再以函式將回傳的內容（可能是 JSON 格式）解析以顯示在網頁中。

## 要如何存取跨網域的 API？
除了上面提到的 JSONP 以外， CORS 通常透過 preflight request (預檢請求) 的方式，使伺服器「先」確認請求內容中是否存在特定的 header（例如 Access-Control-Request-Method 和 Access-Control-Request-Headers，分別確認請求的 HTTP 方法和夾帶 header）。
確認後，瀏覽器才能真正發送往伺服器的請求本身，透過預檢請求可以阻止來源不被允許的請求送出，以達到允許跨網域請求又管制請求內容的效果。
另外，不透過預檢請求進行 CORS 的方法則被稱為簡單請求，簡單請求支援的 headers 跟方法種類較少（例如 Access-Control-Allow-Origin，便是根據請求的來源自動判斷可接受請求的範圍）。

## 為什麼我們在第四週時沒碰到跨網域的問題，這週卻碰到了？
同源政策的限制只存在於瀏覽器中，其目的在於保護使用者瀏覽的安全性，以避免惡意網站任意存取使用者的 cookie 等重要資料。
但在 Node 的執行環境中，並不存在這樣的限制。

參考資料：
[[教學] CORS 是什麼? 如何設定 CORS?](https://shubo.io/what-is-cors/)
[【Web】徹底理解同源政策（Same Origin Policy）](https://someone.tw/2020/05/20/web-same-origin-policy/)