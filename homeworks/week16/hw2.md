輸出依序為：i:0、i:1、i:2、i:3、i:4、5、5、5、5、5。
延續 hw1，setTimeout 的內容會在執行後被丟出 call stack ，在倒數完後才會進入 callback queue。
因此，for 迴圈會先依序印出 i:0 到 i:4 ，在 main() 離開 call stack 後才由 event loop 依次放入 callback queue 排隊的五次 console.log(i)。
此時 i 的值由於宣告使用的是 var 而非 let，會是在迴圈終止時的 5，因此以間隔一秒的頻率輸出 5 次 5（i * 1000 分別為 0 到 4000），若使用 let 則輸出 0、1、2、3、4。

*註：這題我其實沒有搞懂為何使用 let 的情況下 setTimeout 的輸出能抓到正確的 i 值而非 undefined。