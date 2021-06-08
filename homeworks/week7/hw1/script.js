/* eslint-disable no-undef */
const formInput = document.querySelectorAll('.input')
const jointype1 = document.getElementById('bed')
const jointype2 = document.getElementById('floor')
const alertBoxname = ['暱稱', '電子郵件', '電話號碼', '如何知道這個活動']
const alertBoxid = ['alert__name', 'alert__email', 'alert__tel', 'alert__reason']
let jointypeText = []

document.querySelector('.form').addEventListener('submit', (e) => { // 監聽表單送出
  let pass = 0
  for (let i = 0; i < formInput.length - 1; i++) { // 檢查文字輸入欄位
    pass += checkColumn(i, formInput[i].value)
  }
  pass += checkColumnradio() // 檢查勾選欄位
  if (!(pass)) { // 送出表格，輸出填寫內容
    alert(
            `\t\t你的資料：
            暱稱：${formInput[0].value}
            電子郵件：${formInput[1].value}
            電話號碼：${formInput[2].value}
            報名類型：${formInput[3].value}
            如何知道這個活動：${jointypeText}
            其他：${formInput[4].value}`
    )
  } else { // 內容有誤，阻止送出
    alert(
      `你共有 ${pass} 個欄位未正確填寫！`
    )
    e.preventDefault()
  }
})
function checkColumn(column, value) {
  if (!(value)) {
    alert(`請輸入${alertBoxname[column]}`)
    columnAlert(formInput[column], alertBoxid[column])
    return 1
  } return 0
}
function checkColumnradio() {
  if (!(jointype1.checked) && !(jointype2.checked)) {
    alert('請勾選報名類型')
    columnAlert(jointype2, 'alert__jointype')
    return 1
  }
  if (jointype1.checked) {
    jointypeText = '躺在床上用想像力實作'
  } else {
    jointypeText = '趴在地上滑手機找現成的'
  }
  return 0
}
function columnAlert(column, alert) { // 顯示提示文字
  const Alertbox = document.getElementById(`${alert}`)
  Alertbox.classList.add('hint__active')
  column.classList.add('column__active')
}
/* 舊寫法留著
  const name = document.querySelector('input[name=name]')
  const email = document.querySelector('input[name=email]')
  const tel = document.querySelector('input[name=tel]')
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
  if (!(tel.value)) {
    pass = columnAlert(tel, alert__tel.id)
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
  } */
