let nowGames = ''
let nowStreams = 20
const gameList = document.querySelectorAll('.game__title')
window.onload = function() { // 載入起始畫面
  getGames()
}

function getGames() { // 取得熱門遊戲，載入最熱門遊戲的實況
  try {
    const games = new XMLHttpRequest()
    games.open('GET', 'https://api.twitch.tv/kraken/games/top', true)
    games.setRequestHeader('Client-ID', 'f8p79wv5dwns4cp8p9mbpkzk4ae4jh')
    games.setRequestHeader('Accept', 'application/vnd.twitchtv.v5+json')
    games.send()
    games.onerror = function() {
      alert('錯誤')
    }
    games.onload = function(e) {
      const gameResult = JSON.parse(games.responseText)
      for (let i = 0; i < 5; i++) {
        const gametitle = `${gameResult.top[i].game.name}`
        gameList[i].innerHTML = `<span>${i + 1}</span>${gametitle}`
        gameList[i].dataset.gamename = gametitle
        const gameImg = document.querySelectorAll('.game__img')
        gameImg[i].src = gameResult.top[i].game.box.medium
      }
      getStreams(gameResult.top[0].game.name, 20)
    }
  } catch (err) {
    console.log('錯誤！', err)
  }
}
function getStreams(game, limit) { // 取得指定遊戲的實況
  nowGames = game
  try {
    const streams = new XMLHttpRequest()
    streams.open('GET', `https://api.twitch.tv/kraken/streams/?game=${game}&limit=${limit}`, true)
    streams.setRequestHeader('Client-ID', 'f8p79wv5dwns4cp8p9mbpkzk4ae4jh')
    streams.setRequestHeader('Accept', 'application/vnd.twitchtv.v5+json')
    streams.send()
    streams.onerror = function() {
      alert('系統不穩定，請再試一次')
    }
    streams.onload = function(e) {
      const streamResult = JSON.parse(streams.responseText)
      console.log(streamResult)
      document.querySelector('.streams').innerHTML = ''
      for (let i = 0; i < limit; i++) {
        const nowStream = document.createElement('div')
        nowStream.classList.add('stream__object')
        if (i >= 9) { // 分開處理個位數跟十位數的排版，但覺得寫得不太好
          nowStream.innerHTML = `<a href='${streamResult.streams[i].channel.url}' target='_blank'><div class='streams__img'><img src='${streamResult.streams[i].preview.medium}'></div>
                              <span class='tens'>${i + 1}</span>
                              <div class='streams__name'>${streamResult.streams[i].channel.display_name}: ${streamResult.streams[i].viewers} viewers</div>
                              <div class='streams__title'>${streamResult.streams[i].channel.status}</div></a>`
        } else {
          nowStream.innerHTML = `<a href='${streamResult.streams[i].channel.url}' target='_blank'><div class='streams__img'><img src='${streamResult.streams[i].preview.medium}'></div>
                              <span>${i + 1}</span>
                              <div class='streams__name'>${streamResult.streams[i].channel.display_name}: ${streamResult.streams[i].viewers} viewers</div>
                              <div class='streams__title'>${streamResult.streams[i].channel.status}</div></a>`
        }
        document.querySelector('.streams').appendChild(nowStream)
      }
      const emptyBox = document.createElement('div')
      const addMore = document.createElement('div')
      if (nowStreams < 100) {
        addMore.classList.add('stream__object')
        addMore.classList.add('add__button')
        addMore.innerHTML = '<button class="add">載入更多</button>'
        document.querySelector('.streams').appendChild(addMore)
      }
      emptyBox.classList.add('empty__object')
      document.querySelector('.streams').appendChild(emptyBox)
      document.querySelector('.streams').appendChild(emptyBox)
    }
  } catch (err) {
    console.log('錯誤！', err)
  }
}

document.querySelector('.game__bar').addEventListener('click', (e) => { // 切換顯示實況之遊戲
  if (e.target.classList.contains('game__title')) {
    nowStreams = 20
    const clickedButton = e.target.closest('button')
    const thatGame = clickedButton.dataset.gamename
    getStreams(thatGame, 20)
    const allButton = document.getElementsByClassName('game__title')
    for (let i = 0; i < allButton.length; i++) {
      allButton[i].classList.remove('game__now')
    }
    clickedButton.classList.add('game__now')
    document.getElementsByTagName('h1')[0].innerText = `Twitch 熱門實況遊戲列表：${thatGame}`
  }
})

document.querySelector('.streams').addEventListener('click', (e) => {
  if (e.target.classList.contains('add__button') || e.target.classList.contains('add')) {
    getMorestreams()
  }
})

function getMorestreams() {
  nowStreams += 20
  getStreams(nowGames, nowStreams)
}
