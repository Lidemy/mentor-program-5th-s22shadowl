
const got = require('got');

(async() => {
  try {
    const response = await got('https://lidemy-book-store.herokuapp.com/books?_limit=10')
    const bookForm = JSON.parse(response.body)
    for (let i = 0; i < bookForm.length; i++) {
      console.log(bookForm[i].id, bookForm[i].name)
    }
  } catch (error) {
    console.log('資料讀取錯誤!')
  }
})()
