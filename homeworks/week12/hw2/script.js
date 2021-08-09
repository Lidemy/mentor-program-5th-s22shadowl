$(document).ready((e) => {
  function appendTodoToDOM(container, todos) {
    const html = `<div class='card bg-info m-2 ${todos.status}'>
        <button type='button' id='input__button' class='todo bg-info d-flex h-100'>
        <p class="del-btn btn btn-danger position-absolute top-0 end-0 fs-2 m-1">刪除</p>
        <p class=" btn btn-danger position-absolute top-0 start-0 fs-2 m-1">編輯</p>
        <div class='bg-info text-center my-auto text-danger fs-3 w-100 align-self-center todo-content'>${todos.content}</div>
        </button>
        </div>`
    container.append(html)
  }
  // 在 JS 取得 uid 參數、讀取待辦
  const URL = location.href
  const cardsDOM = $('.cards')
  let uid = null
  if (URL.indexOf('?') !== -1) {
    const urlArray = URL.split('?')[1].split('&')
    for (let i = 0; i < urlArray.length; i++) {
      if (urlArray[i].split('=')[0] === 'uid') {
        const urlUid = urlArray[i].split('=')[1]
        uid = urlUid
      }
    }
  }
  console.log(uid)
  if (uid) {
    $.ajax({
      url: `http://mentor-program.co/mtr04group1/s22shadowl/week12/todos/api_todos.php?uid=${uid}`
    }).done((data) => {
      if (!data.ok) {
        alert(data.message)
        return
      }
      const todos = JSON.parse(data.todos[0].todos)
      for (let i = 0; i < todos.length; i++) {
        appendTodoToDOM(cardsDOM, todos[i])
      }
    })
  }
  // 新增待辦
  $('.add-btn').click((e) => {
    const addContent = $('input[name=add-content]').val()
    if (addContent) {
      const todoTemplate = `<div class='card bg-info m-2'>
                                        <button type='button' id='input__button' class='todo bg-info d-flex h-100'>
                                            <p class="del-btn btn btn-danger position-absolute top-0 end-0 fs-2 m-1">刪除</p>
                                            <p class=" edit-btn btn btn-danger position-absolute top-0 start-0 fs-2 m-1">編輯</p>
                                            <div class='bg-info text-center my-auto text-danger fs-3 w-100 align-self-center todo-content'>${addContent}</div>
                                        </button>
                                    </div>`
      $('.cards').append(todoTemplate)
    }
  })
  // 動態新增：編輯、刪除、編輯完成、修改狀態
  $(document).on('click', '.del-btn', (e) => {
    e.target.closest('.card').remove()
  })
  $(document).on('click', '.edit-btn', (e) => {
    const editTodo = e.target.closest('.card')
    const editTodotext = $(editTodo).find('.todo-content').text()
    $(editTodo).html(`
        <button type='button' id='input__button' class='todo bg-info d-flex h-100'>
            <p class="del-btn btn btn-danger position-absolute top-0 end-0 fs-2 m-1">刪除</p>
            <p class="edit-btn-done btn btn-danger position-absolute top-0 start-0 fs-2 m-1">完成</p>
            <input type='text' class='bg-info text-center my-auto text-danger fs-3 w-100 align-self-center edit-todo' name='add-content' placeholder='${editTodotext}'>
        </button>`)
  })
  $(document).on('click', '.edit-btn-done', (e) => {
    const editTodo = e.target.closest('.card')
    $(editTodo).html(`
        <button type='button' id='input__button' class='todo bg-info d-flex h-100'>
            <p class="del-btn btn btn-danger position-absolute top-0 end-0 fs-2 m-1">刪除</p>
            <p class="edit-btn btn btn-danger position-absolute top-0 start-0 fs-2 m-1">編輯</p>
            <div class='bg-info text-center my-auto text-danger fs-3 w-100 align-self-center todo-content'>${$('.edit-todo').val()}</div>
        </button>`)
  })
  $(document).on('dblclick', '.card', (e) => {
    const undoneTodo = e.target.closest('.card')
    $(undoneTodo).toggleClass('undone')
  })
  // 顯示切換、儲存、清空、讀取。
  $('.done-btn').click((e) => {
    $('.card').show()
    $('.undone').hide()
  })
  $('.undone-btn').click((e) => {
    $('.card').hide()
    $('.input-todo').show()
    $('.undone').show()
  })
  $('.all-btn').click((e) => {
    $('.card').show()
  })
  $('.clear-btn').click((e) => {
    $('.cards').html(
            `<div class='card bg-info m-2 input-todo'>
                <button type='button' id='input__button' class='todo bg-info d-flex h-100'>
                    <p class="add-btn btn btn-danger position-absolute top-0 end-0 fs-2 m-1">新增</p>
                    <input type='text' class='bg-info text-center my-auto text-danger fs-3 w-100 align-self-center' name='add-content' placeholder='Add Some Todo!'>
                </button>
            </div>`)
  })
  $('.save-btn').click((e) => {
    const todos = $('.card')
    const savedTodos = []
    const savedUid = (uid) || $('.uid').text()

    for (let i = 1; i < todos.length; i++) {
      let todoStatus = null
      if ($(todos[i]).hasClass('undone')) {
        todoStatus = 'undone'
      }
      savedTodos.push({
        content: $(todos[i]).find('.todo-content').text().trim(),
        status: todoStatus
      })
    }
    const savedData = {
      uid: savedUid,
      todos: JSON.stringify(savedTodos)
    }
    console.log(savedData)
    $.ajax({
      type: 'POST',
      url: 'http://mentor-program.co/mtr04group1/s22shadowl/week12/todos/api_save_todo.php',
      data: savedData
    }).done((data) => {
      if (!data.ok) {
        alert(data.message)
        return
      }
      window.location = `http://mentor-program.co/mtr04group1/s22shadowl/week12/todos/index.php?uid=${savedUid}`
    })
  })
  $('.load-btn').click((e) => {
    window.location = `http://mentor-program.co/mtr04group1/s22shadowl/week12/todos/index.php?uid=${$('.uid-input').val()}`
  })
})
