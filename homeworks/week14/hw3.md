## 什麼是 DNS？Google 有提供的公開的 DNS，對 Google 的好處以及對一般大眾的好處是什麼？
DNS 是一種為了降低網際網路使用時間成本所誕生的服務，其將網路中由數字組成的長串 IP 地址轉換成具有語意、可讀性較高的網址（例如 198.35.26.96 → zh.wikipedia.org ）。
DNS 的原理是在使用者輸入網址後，由瀏覽器向 DNS伺服器發送查詢請求，接下來 DNS伺服器會根據網址的結構，依序向各個級別的域名伺服器進行查詢。
查詢過程是由網址的尾端向前，以「.」為單位依區段查詢，以 zh.wikipedia.org 為例（原始的網址格式中最尾端應該還有一個「.」，現在能在解析時自動加上，已經不再需要輸入）：
DNS 會確認伺服器中的快取是否存有目標的紀錄，若有即可直接返回 IP 位址
若沒有會先向 根域名（root）伺服器發送請求，尋找名為 org 的頂級域名伺服器位址，
再由此向 org 域名伺服器請求尋找 wikipedia 的次級域名伺服器位址，
最後再向 wikipedia 域名伺服器請求尋找 zh 的三級域名伺服器位址，
並將其返回給使用者。

Google 提供的 Public DNS 服務是大眾除了 ISP（網路供應商）提供的 DNS 服務以外，最常使用的 DNS 選擇之一。
使用由 Google 自行架設的 DNS 伺服器對於一般大眾而言有以下幾點好處：
1.DNS IP 比較好記。 8.8.8.8 真的很難忘記XD
2.域名更新的速度較快。相較一般 ISP，Google DNS 由於規模較大，掌握了較完整的 IP 資料，在域名發生變動時不需像一般 ISP 服務商一樣花費數個小時才能更新資訊。
3.安全性。這點可以打個星號，雖然 Google 聲稱使用他們的 DNS 服務可以避免用戶的上網紀錄被 ISP 掌握並利用，但我們很難保證 Google 就不會做一樣的事......
4.穩定性。跟一般的 ISP 比較，Google DNS 的規模使得其服務不太可能因為停電、失火之類的原因導致整個服務失效。

對於 google 而言，提供 DNS 服務器好處則是可以蒐集使用者的所有瀏覽紀錄。

## 什麼是資料庫的 lock？為什麼我們需要 lock？
資料庫的 Lock 功能用於防止檔案在同時進行多筆讀寫時產生衝突，Lock 會在讀寫中的檔案中加上狀態，使得其他讀寫指令在碰到該檔案時進行等待/或僅能進行讀取而無法寫入。
根據不同需求，Lock 功能可以觸發於不同的層級，從一個最小的 row （一筆紀錄）到整個 database 都有可能。
從基礎來說， Lock 保證了交易遵守 ACID 原則中的隔離性 (Isolation) 。

## NoSQL 跟 SQL 的差別在哪裡？
非關聯式資料庫 NoSQL 與 SQL 的最大差異在於資料儲存的結構，NoSQL 拋棄了 SQL 使用的 schema 以換取資料存取更大的彈性。
NoSQL 資料庫中的資料之間預設不存在對應的關聯，因此較方便就個別資料或是整個資料庫進行調整，包括資料庫的擴充。
相對而言，NoSQL 的缺點是不易進行 SQL 中常利用的複雜化查詢（例如 JOIN 以及各種進階語法）、以及較不利於系統化的整理其中的資料（如產生BI、報表等）。
但以上缺點基本上是由於 NoSQL 預設希望處理的資料類型與 SQL 不同，其強項在於處理結構性較低、甚至是非結構化的大量資訊。
整體來說，SQL 與 NoSQL 的關係就像生魚片刀與剁肉刀，兩者由於要處理的對象不同因而存在各自的優缺點，之間不存在優劣關係，在實際料理時也可能同時利用到。

## 資料庫的 ACID 是什麼？
ACID 是資料庫在進行資料交易時，應該遵守的四個特性：原子性、一致性、隔離性與持續性的統稱。
原子性 (Atomicity)：要求交易的完成與否是不可分割的，也就是只存在命令全部執行與全部不執行兩種結果，若執行途中產生錯誤，則取消先前所有已完成的部分，稱為「回滾（Rollback）」。
一致性 (Consistency)：要求交易前後的資料都必須遵守先前資料庫所規劃的規則或性質，例如欄位資料型態、外部鍵，否則也會產生 Rollback。
隔離性 (Isolation) ：要求資料不會同時受到複數交易的更動，也就是將交易中的資料進行隔離，避免資料庫發生衝突、或交易產生錯誤的結果。
持續性 (Durability) ：要求資料在完成交易後必須能夠在資料庫永久保存，除非主動刪除，否則即使系統當機、發生錯誤也不會影響舊資料的存儲。
資料庫除了必須遵守 ACID 以外，同時也應該試圖提高 ACID 各相關功能的執行速度，以提升整體的效能。

參考資料：
[閃開！讓專業的來：SQL 與 NoSQL](https://ithelp.ithome.com.tw/articles/10187443)
[了解NoSQL不可不知的5項觀念](https://www.ithome.com.tw/news/92506)
[關於NoSQL與SQL的區別](https://read01.com/GPnEx.html#.YR3drd9-WUk)
[什麼是SQL？什麼是NoSQL? 用簡單範例看一下他們的差異吧！](https://codegym.tech/blog/sql_vs_nosql.html)
[交易鎖定與資料列版本設定指南](https://docs.microsoft.com/zh-tw/sql/relational-databases/sql-server-transaction-locking-and-row-versioning-guide?view=sql-server-ver15)
* 這篇很細，只看了大概。
[#54 資料庫的 Transaction (交易) - ACID 基本介紹](http://www.woolycsnote.tw/2017/07/54-transaction-acid.html)
[改個 DNS 是要改多久？- Domain 管理的常見問題](https://medium.com/starbugs/%E9%80%A3-pm-%E4%B9%9F%E6%87%89%E8%A9%B2%E7%9F%A5%E9%81%93%E7%9A%84-dns-%E5%B0%8F%E7%9F%A5%E8%AD%98-d00b43e4fe9a)
[用 Google 的 Public DNS 上網會變快？Google的DNS真的比較快嗎？之常用DNS測試](https://www.peterdavehello.org/2014/01/is_google_dns_faster/)
