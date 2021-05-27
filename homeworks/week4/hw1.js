
const got = require('got');

(async() => {
  const response = await got('https://lidemy-book-store.herokuapp.com/books?_limit=10')
  if (response.statusCode >= 200 && response.statusCode < 300) {
    let bookForm = []
    try {
      bookForm = JSON.parse(response.body)
    } catch (error) {
      console.log('資料庫讀取錯誤')
    }
    for (let i = 0; i < bookForm.length; i++) {
      console.log(bookForm[i].id, bookForm[i].name)
    }
  } else {
    console.log('程式執行錯誤!')
  }
})()
