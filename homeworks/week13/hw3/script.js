const gameList = $('.game__title')
const fetchParams = {
  method: 'GET',
  headers: {
    'Client-ID': 'f8p79wv5dwns4cp8p9mbpkzk4ae4jh',
    Accept: 'application/vnd.twitchtv.v5+json'
  },
  mode: 'cors',
  cache: 'default'
}
let nowGames = ''
let nowStreams = 20

window.onload = function() { // 載入起始畫面
  loadStreams()
}

async function loadStreams() { // 取得熱門遊戲，載入最熱門遊戲的實況
  try {
    const data = await getHotGames()
    await getStreams(data.top[0].game.name, 20)
    await appendGameListToDOM(data)
  } catch (err) {
    console.log('錯誤！', err)
  }
}

async function getHotGames() {
  try {
    const response = await fetch('https://api.twitch.tv/kraken/games/top', fetchParams)
    const data = await response.json()
    return data
  } catch (err) {
    console.log('錯誤！', err)
  }
}

async function getStreams(game, limit) { // 取得指定遊戲的實況
  nowGames = game
  try {
    const response = await fetch(`https://api.twitch.tv/kraken/streams/?game=${game}&limit=${limit}`, fetchParams)
    const data = await response.json()
    appendStreamsToDOM(data, limit)
  } catch (err) {
    console.log('錯誤！', err)
  }
}

function appendGameListToDOM(data) {
  for (let i = 0; i < 5; i++) {
    const gametitle = `${data.top[i].game.name}`
    $(gameList[i]).html(`<span>${i + 1}</span>${gametitle}`)
    $(gameList[i]).data('gamename', gametitle)
    const gameImg = $('.game__img')
    gameImg[i].src = data.top[i].game.box.medium
  }
}

function getMorestreams() {
  nowStreams += 20
  getStreams(nowGames, nowStreams)
}

function appendStreamsToDOM(data, limit) {
  $('.streams').empty()
  for (let i = 0; i < limit; i++) {
    const nowStream = $(`<div class=stream__object>
                          <a href='${data.streams[i].channel.url}' target='_blank'>
                            <div class='streams__img'>
                              <img src='${data.streams[i].preview.medium}'>
                            </div>
                            <span>${i + 1}</span>
                            <div class='streams__name'>${data.streams[i].channel.display_name}: ${data.streams[i].viewers} viewers</div>
                            <div class='streams__title'>${data.streams[i].channel.status}</div>
                          </a>
                        </div>`)
    $('.streams').append(nowStream)
  }

  const emptyBox = $("<div class='empty__object'></div>")
  const addMore = $("<div class='stream__object add__button'><button class='add'>載入更多</button></div>")

  if (nowStreams < 100) {
    $('.streams').append(addMore)
  }
  $('.streams').append(emptyBox)
  $('.streams').append(emptyBox)
}

$('.game__bar').click((e) => { // 切換顯示實況之遊戲
  if (e.target.classList.contains('game__title')) {
    nowStreams = 20
    const clickedButton = e.target.closest('button')
    const thatGame = $(clickedButton).data('gamename')
    getStreams(thatGame, 20)
    const allButton = $('.game__title')
    for (let i = 0; i < allButton.length; i++) {
      $(allButton[i]).removeClass('game__now')
    }
    clickedButton.classList.add('game__now')
    $('h1').text(`Twitch 熱門實況遊戲列表：${thatGame}`)
  }
})

document.querySelector('.streams').addEventListener('click', (e) => {
  if (e.target.classList.contains('add__button') || e.target.classList.contains('add')) {
    getMorestreams()
  }
})
