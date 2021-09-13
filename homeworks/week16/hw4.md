程式依序會輸出 2、2、undefined。

由於 this 的值是根據呼叫方式決定，所以看似都是在呼叫同一個 function hello 的三次呼叫會輸出不同的結果。
由轉換成 function call 的形式理解物件中 this 的值的話，可將 x.y() 理解為 x.y.call(x) 的意思。
第一行 obj.inner.hello() 可以理解成 obj.inner.hello.call(obj.inner)，因此 this 就是後者參數的 obj.inner，value 為對應的 2。
第二行 obj2.hello() 可以理解成 obj2.hello.call(obj2)，因此 this 為後者參數的 obj2，而 obj2 又被賦值為 obj.inner，因此 value 同樣為 2。
第三行 hello() 可以理解成 hello.call()，因此 this 為後者的參數，即空值，此時 this 會依據環境及設定不同，可能是 global、window 或是 undefined，但由於此時 console.log 的是 this.value，因此無論環境，輸出都是 undefined。
