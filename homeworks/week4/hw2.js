const orderInput = process.argv
const bookFormurl = 'https://lidemy-book-store.herokuapp.com/books'
const got = require('got');

(async(order = orderInput[2]) => {
  switch (order) {
    case 'list': {
      const response = await got(`${bookFormurl}?_limit=20`)
      if (response.statusCode >= 200 && response.statusCode < 300) {
        let bookForm = []
        try {
          bookForm = JSON.parse(response.body)
        } catch (err) {
          console.log('資料庫格式錯誤！')
          console.log(err)
        }
        for (let i = 0; i < bookForm.length; i++) {
          console.log(bookForm[i].id, bookForm[i].name)
        }
      }
      break
    }
    case 'read' : {
      const response = await got(bookFormurl)
      let bookForm = []
      try {
        bookForm = JSON.parse(response.body)
      } catch (err) {
        console.log('資料庫格式錯誤！')
        console.log(err)
      }
      for (let i = 0; i < bookForm.length; i++) {
        if (bookForm[i].id === Number(orderInput[3])) {
          console.log(bookForm[i].name)
        }
      }
      break
    }
    case 'delete' : {
      got.delete(
          `${bookFormurl}/${orderInput[3]}`)
      console.log('刪除成功！')
      break
    }
    case 'create' : {
      got.post(
        {
          url: bookFormurl,
          form: {
            name: orderInput[3]
          }
        })
      console.log('新增成功！')
      break
    }
    case 'update': {
      got.patch({
        url: `${bookFormurl}/${orderInput[3]}`,
        form: {
          name: orderInput[4]
        }
      })
      break
    }
    default:
      console.log('指令輸入錯誤！可用指示為：list, read, delete, create, update')
      break
  }
})()
