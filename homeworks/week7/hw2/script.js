document.querySelector('.section__desc').addEventListener('click', (e) => {
  const answer = e.target.closest('.question')
  answer.classList.toggle('hide')
})

/* 沒用到事件代理的寫法，留著當紀念
const answer = document.querySelectorAll('.question > div')
for (let i = 0; i < question.length; i++) {
  answer[i].style.display = 'none'
  question[i].addEventListener('click', (e) => {
    if (answer[i].style.display === 'none') {
      answer[i].style.display = 'block'
    } else {
      answer[i].style.display = 'none'
    }
  })
} */
