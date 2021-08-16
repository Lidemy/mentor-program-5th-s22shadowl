const todoTemplate = `<div class='card bg-info m-2 {status}'>
                        <button type='button' id='input__button' class='todo bg-info d-flex h-100'>
                          <p class="del-btn btn btn-danger position-absolute top-0 end-0 fs-2 m-1">刪除</p>
                          <p class=" edit-btn btn btn-danger position-absolute top-0 start-0 fs-2 m-1">編輯</p>
                          <div class='bg-info text-center my-auto text-danger fs-3 w-100 align-self-center todo-content'>{content}</div>
                        </button>
                      </div>`

const todoEditTemplate = `<div class='card bg-info m-2 input-todo'>
                            <button type='button' id='input__button' class='todo bg-info d-flex h-100'>
                                <p class="{btn-for} btn btn-danger position-absolute top-0 end-0 fs-2 m-1">{btn-text}</p>
                                <input type='text' class='bg-info text-center my-auto text-danger fs-3 w-100 align-self-center {class}' name='{name}' placeholder='{placeholder}'>
                            </button>
                          </div>`

$(document).ready((e) => {
  function appendTodoToDOM(container, todos) {
    const html = todoTemplate
      .replace('{status}', todos.status)
      .replace('{content}', todos.content)
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
      const todo = todoTemplate
        .replace('{status}', '')
        .replace('{content}', addContent)
      $('.cards').append(todo)
    }
  })
  // 動態新增：編輯、刪除、編輯完成、修改狀態
  $(document).on('click', '.del-btn', (e) => {
    e.target.closest('.card').remove()
  })
  $(document).on('click', '.edit-btn', (e) => {
    const editTodo = e.target.closest('.card')
    const editTodotext = $(editTodo).find('.todo-content').text()
    $(editTodo).prop('outerHTML', todoEditTemplate
      .replace('{placeholder}', editTodotext)
      .replace('{class}', 'edit-todo')
      .replace('{btn-for}', 'edit-btn-done')
      .replace('{btn-text}', '完成'))
  })
  $(document).on('click', '.edit-btn-done', (e) => {
    const editTodo = e.target.closest('.card')
    const editTodotext = $('.edit-todo').val()
    $(editTodo).prop('outerHTML', todoTemplate
      .replace('{content}', editTodotext))
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
    $('.cards').html(todoEditTemplate
      .replace('{placeholder}', 'ADD SOME TODO NOW')
      .replace('{btn-for}', 'add-btn')
      .replace('{name}', 'add-content')
      .replace('{btn-text}', '新增'))
  })
  $('.save-btn').click((e) => {
    const todos = $('.card')
    const savedTodos = []
    const savedUid = (uid) || $('.uid').text()

    for (const todo of todos) {
      if (!($(todo).hasClass('input-todo'))) {
        let todoStatus = null
        if ($(todo).hasClass('undone')) {
          todoStatus = 'undone'
        }
        savedTodos.push({
          content: $(todo).find('.todo-content').text().trim(),
          status: todoStatus
        })
      }
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
