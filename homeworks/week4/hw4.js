/* eslint-disable prefer-template */
const got = require('got');

(async() => {
  try {
    const response = await got({
      url: 'https://api.twitch.tv/kraken/games/top',
      headers: {
        'Client-ID': 'f8p79wv5dwns4cp8p9mbpkzk4ae4jh',
        Accept: 'application/vnd.twitchtv.v5+json'
      }
    })
    const bookForm = JSON.parse(response.body)
    for (let i = 0; i < bookForm.top.length; i++) {
      console.log(bookForm.top[i].viewers + ' ' + bookForm.top[i].game.name)
    }
  } catch (error) {
    console.log('資料取得失敗!')
  }
})()
