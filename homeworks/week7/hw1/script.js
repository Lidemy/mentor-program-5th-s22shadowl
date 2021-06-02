/* eslint-disable no-unused-vars */
/* eslint-disable no-undef */
const form = document.querySelector('.form')
form.addEventListener('submit', (e) => {
  const name = document.querySelector('input[name=name]')
  const email = document.querySelector('input[name=email]')
  const number = document.querySelector('input[name=number]')
  const jointype1 = document.getElementById('bed')
  const jointype2 = document.getElementById('floor')
  const reason = document.querySelector('input[name=reason]')
  const other = document.querySelector('input[name=other]')
  let pass = true
  if (!(name.value)) {
    pass = columnAlert(name, alert__name.id)
    alert('請輸入暱稱')
    e.preventDefault()
  }
  if (!(email.value)) {
    pass = columnAlert(email, alert__email.id)
    alert('請輸入電子郵件')
    e.preventDefault()
  }
  if (!(number.value)) {
    pass = columnAlert(number, alert__number.id)
    alert('請輸入電話號碼')
    e.preventDefault()
  }
  if (!(jointype1.checked) && !(jointype2.checked)) {
    pass = columnAlert(jointype2, alert__jointype.id)
    alert('請勾選報名類型')
    e.preventDefault()
  }
  if (!(reason.value)) {
    pass = columnAlert(reason, alert__reason.id)
    alert('請輸入如何知道這個活動')
    e.preventDefault()
  }
  if (pass) {
    alert(
            `\t\t你的資料：
            暱稱：${name.value}
            電子郵件：${email.value}
            電話號碼：${number.value}
            報名類型：${jointype1.value} ${jointype2.value}
            如何知道這個活動：${reason.value}
            其他：${other.value}`
    )
  }
})
function columnAlert(column, alert) {
  const hintAlert = document.getElementById(`${alert}`)
  hintAlert.classList.add('hint__active')
  column.classList.add('column__active')
  return false
}
