const totalTodos = document.getElementsByClassName('created__button')
const todoNow = document.querySelector('.todo__now')
todoNow.innerText = `目前的備忘數量：${totalTodos.length}`

document.getElementById('add__icon').addEventListener('click', () => {
  const text = document.querySelector('input[name=add__inputbox]')
  if (text.value) {
    const newtodo = document.createElement('button')
    newtodo.classList.add('button')
    newtodo.classList.add('created__button')
    newtodo.innerHTML = `${text.value}<icon class='del__icon'>X</icon>`
    document.querySelector('.todo__box').appendChild(newtodo)
    todoNow.innerText = `目前的備忘數量：${totalTodos.length}`
    text.value = ''
  }
})
document.querySelector('.todo__box').addEventListener('click', (e) => {
  if (e.target.classList.contains('del__icon')) {
    document.querySelector('.todo__box').removeChild(e.target.closest('button'))
    todoNow.innerText = `目前的備忘數量：${totalTodos.length}`
  }
})
document.querySelector('.todo__box').addEventListener('click', (e) => {
  if (e.target.classList.contains('created__button')) {
    const clickedButton = e.target.closest('button')
    clickedButton.classList.toggle('checked')
  }
})
