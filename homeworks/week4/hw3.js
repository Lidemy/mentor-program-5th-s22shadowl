const keyword = process.argv[2]
let response
const got = require('got');

(async() => {
  try {
    response = await got(`https://restcountries.eu/rest/v2/name/${keyword}`)
  } catch (err) {
    return console.log('找不到國家資訊')
  }
  if (response.statusCode >= 200 && response.statusCode < 300) {
    let nationINF = []
    try {
      nationINF = JSON.parse(response.body)
    } catch (err) {
      console.log('資料讀取錯誤！')
    }
    for (let i = 0; i < nationINF.length; i++) {
      console.log('=======')
      console.log(`國家：${nationINF[i].name}`)
      console.log(`首都：${nationINF[i].capital}`)
      console.log(`貨幣：${nationINF[i].currencies[0].code}`)
      console.log(`國碼：${nationINF[i].callingCodes[0]}`)
    }
  }
})()

/* 不太確定為什麼不能用的錯誤寫法（搜尋功能會有問題）：
const keyword = process.argv[2]
const got = require('got');

(async() => {
  try {
    const response = await got('https://restcountries.eu/rest/v2/all')
    const nationINF = JSON.parse(response.body)
    for (let i = 0; i < nationINF.length; i++) {
      // console.log(nationINF[i].altSpellings)
      if (nationINF[i].altSpellings.includes(keyword) || nationINF[i].name.includes(keyword)) {
        console.log('=======')
        console.log('國家：' + nationINF[i].name)
        console.log('首都：' + nationINF[i].capital)
        console.log('貨幣：' + nationINF[i].currencies[0].code)
        console.log('國碼：' + nationINF[i].numericCode)
      }
    }
  } catch (error) {
    console.log(error.response.body)
  }
})()
 */
