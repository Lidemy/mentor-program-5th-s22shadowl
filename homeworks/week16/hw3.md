輸出結果會是 undefined、5、6、20、1、10、100

執行順序
1.瀏覽器首先建立 globalEC，在 VO 中初始化後宣告變數 var 為 undefined、fn 為 function。
2.執行 var a = 1，將 1 賦值給 VO 中的 a。
3.執行 fn()，建立 fn() 的 EC，在 AO 中初始化後宣告變數 var 為 undefined、fn2 為 function。
4.在 fn() 中執行 console.log(a)，由 fnEC 的 AO 中找到結果：a 是 undefined，印出。
5.執行 var a = 5，將 5 賦值給 fnEC AO 中的 a。
6.執行 console.log(a)，由 fnEC 的 AO 中找到結果：a 是 5，印出。
7.執行 a++，將 a+1 = 6 賦值給 fnEC AO 中的 a。
8.執行 var a，已經宣告過了，忽略。
9.執行 fn2()，建立 fn2() 的 EC，其 AO 初始化後由於 fn2() 中沒有宣告目前為空。
10.在 fn2() 中執行 console.log(a)，由於在其 AO 中沒有找到 a，由 scope chain 向外尋找，在 fnEC 的 AO 中找到結果：a 是 6，印出。
11.執行 a = 20，由於在其 AO 中沒有找到 a，由 scope chain 向外尋找，在 fnEC 的 AO 中找到 a，賦值為 20。
12.執行 b = 100，由於在其 AO 中沒有找到 a，由 scope chain 向外尋找，直到 globalEC 都沒有找到，在 VO 中宣告 b 賦值為 100。
13.離開 fn2()。
14.離開 fn()。
15.執行 console.log(a)，在 globalEC 的 VO 中找到結果：a 是 1，印出。
16.執行 a = 10，在 globalEC 的 VO 中找到 a，賦值為10。
17.執行 console.log(a)，在 globalEC 的 VO 中找到結果：a 是 10，印出。
18.執行 console.log(b)，在 globalEC 的 VO 中找到結果：b 是 100，印出。

*註：親自 run 過一遍之後有把 hoisting 和作用域的概念搞清楚不少。