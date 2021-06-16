const totalTodos = document.getElementsByClassName('created__button')
const todoNow = document.querySelector('.todo__now')
todoNow.innerText = `目前的備忘數量：${totalTodos.length}`

window.addEventListener('click', (e) => { // 新增 todo
  if (e.target.id === 'add__icon') {
    const text = document.querySelector('input[name=add__inputbox]')
    if (text.value) {
      const newtodo = `<button class='button created__button'>
        ${text.value}
        <icon class='del__icon'>X</icon>
      </button>`
      document.querySelector('.todo__box').innerHTML += newtodo
      todoNow.innerText = `目前的備忘數量：${totalTodos.length}`
      text.value = ''
    }
  }
})
document.querySelector('.todo__box').addEventListener('click', (e) => { // 刪除 todo
  if (e.target.classList.contains('del__icon')) {
    document.querySelector('.todo__box').removeChild(e.target.closest('button'))
    todoNow.innerText = `目前的備忘數量：${totalTodos.length}`
  }
})
document.querySelector('.todo__box').addEventListener('click', (e) => { // 標記 todo 為完成
  if (e.target.classList.contains('created__button')) {
    const clickedButton = e.target.closest('button')
    clickedButton.classList.toggle('checked')
  }
})
/* 舊寫法留著做紀念
  document.getElementById('add__icon').addEventListener('click', () => { // 新增 todo
  const text = document.querySelector('input[name=add__inputbox]')
  console.log('1')
  if (text.value) {
    console.log('2')
     const newtodo = document.createElement('button')
    newtodo.classList.add('button')
    newtodo.classList.add('created__button')
    newtodo.innerHTML = `${text.value}<icon class='del__icon'>X</icon>`
    document.querySelector('.todo__box').appendChild(newtodo)
    const newtodo = `<button class='button created__button'>
      ${text.value}
      <icon class='del__icon'>X</icon>
    </button>`
    document.querySelector('.todo__box').innerHTML += newtodo
    todoNow.innerText = `目前的備忘數量：${totalTodos.length}`
    text.value = ''
  }
}) */
