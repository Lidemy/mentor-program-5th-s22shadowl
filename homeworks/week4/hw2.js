/* eslint-disable prefer-template */
const orderInput = process.argv
const bookFormurl = 'https://lidemy-book-store.herokuapp.com/books/'
const got = require('got');

(async(order = orderInput[2], input = orderInput[3], newname = orderInput[4]) => {
  try {
    const response = await got(bookFormurl)
    const bookForm = JSON.parse(response.body)
    switch (order) {
      case 'list': {
        for (let i = 0; i < 20; i++) {
          console.log(bookForm[i].id, bookForm[i].name)
        }
        break
      }
      case 'read' : {
        for (let i = 0; i < bookForm.length; i++) {
          if (bookForm[i].id === Number(input)) {
            console.log(bookForm[i].name)
          }
        }
        break
      }
      case 'delete' : {
        got.delete(
          bookFormurl + input)
        break
      }
      case 'create' : {
        got.post(
          {
            url: bookFormurl,
            form: {
              name: input
            }
          })
        break
      }
      case 'update': {
        got.patch({
          url: bookFormurl + input,
          form: {
            name: newname
          }
        })
        break
      }
      default:
        break
    }
  } catch (error) {
    console.log(error.response.body)
  }
})()
