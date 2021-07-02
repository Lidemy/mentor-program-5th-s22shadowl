const banner = document.querySelector('.games-banner')
const infoBox = document.querySelector('.games-info')
let drawResult = ''

document.querySelector('.games').addEventListener('click', (e) => {
  if (e.target.classList.contains('games-button')) {
    const draw = new XMLHttpRequest()
    draw.open('GET', 'https://dvwhnbka7d.execute-api.us-east-1.amazonaws.com/default/lottery/', true)
    draw.send()
    draw.onerror = function() {
      alert('系統不穩定，請再試一次')
    }
    draw.onload = function(e) {
      try {
        drawResult = JSON.parse(draw.responseText)
        if (draw.status >= 200 && draw.status < 400) {
          infoBox.classList.add('draw')
          infoBox.classList.remove('none-box')
          banner.classList.remove('none')
          switch (drawResult.prize) {
            case 'FIRST':
              infoBox.innerHTML = '<div>恭喜你中頭獎了！日本東京來回雙人遊！</div><button class="games-button"><span>我要抽獎</span></button>'
              banner.src = 'first-prize.jpg'
              break
            case 'SECOND':
              infoBox.innerHTML = '<div>二獎！90 吋電視一台！</div><button class="games-button"><span>我要抽獎</span></button>'
              banner.src = 'second-prize.jpg'
              break
            case 'THIRD':
              infoBox.innerHTML = '<div>恭喜你抽中三獎：知名 YouTuber 簽名握手會入場券一張，bang！</div><button class="games-button"><span>我要抽獎</span></button>'
              banner.src = 'third-prize.jpg'
              break
            case 'NONE':
              infoBox.innerHTML = '<div>銘謝惠顧</div><button class="games-button"><span>我要抽獎</span></button>'
              infoBox.classList.add('none-box')
              banner.classList.add('none')
              banner.src = 'none.png'
          }
        }
      } catch (error) {
        alert('系統不穩定，請再試一次')
      }
    }
  }
})
