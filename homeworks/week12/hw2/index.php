<?php 
require_once('conn.php');

if (!($_GET['uid'])) { 
    $stmt = $conn->prepare(
        'select max(userid) as max from s22shadowl_todos'
    );
    $result = $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    } 
?>
<!DOCTYPE html>

<html>
<head>
<meta charset="utf-8">
<title>TO DO LIST</title>
<meta name='viewport' content='width=device-width, initial-scale=1'> 
<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
<link rel='stylesheet' href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
<script>
    $(document).ready( e => {
        function appendTodoToDOM(container, todos) {
            const html = `<div class='card bg-info m-2 ${todos.status}'>
            <button type='button' id='input__button' class='todo bg-info d-flex h-100'>
            <p class="del-btn btn btn-danger position-absolute top-0 end-0 fs-2 m-1"></p>
            <p class=" btn btn-danger position-absolute top-0 start-0 fs-2 m-1"></p>
            <div class='bg-info text-center my-auto text-danger fs-3 w-100 align-self-center todo-content'>${todos.content}</div>
            </button>
            </div>`
            container.append(html)
        }
        // 在 JS 取得 uid 參數、讀取待辦
        let URL = location.href
        let uid = null
        let cardsDOM = $('.cards')
        if(URL.indexOf('?') != -1) {
            let urlArray = URL.split('?')[1].split('&')
            console.log(urlArray)
            for(let i=0; i < urlArray.length ; i++) {
                if ( urlArray[i].split('=')[0] == 'uid') {
                    uid = urlArray[i].split('=')[1]
                }
            }
        }
        if(uid) {
            $.ajax({
                    url: `http://mentor-program.co/mtr04group1/s22shadowl/week12/todos/api_todos.php?uid=${uid}`,
                    }).done(function(data) {
                    if (!data.ok) {
                        alert(data.message)
                        return
                    }
                    const todos = JSON.parse(data.todos[0].todos)
                    for (let i = 0 ; i < todos.length ; i++ ) {
                        appendTodoToDOM(cardsDOM, todos[i])
                    }
                }); 
        }
        // 新增待辦
        $('.add-btn').click( e => {
            const add_content = $('input[name=add-content]').val()
            if (add_content) {
                const todo__template = `<div class='card bg-info m-2'>
                                            <button type='button' id='input__button' class='todo bg-info d-flex h-100'>
                                                <p class="del-btn btn btn-danger position-absolute top-0 end-0 fs-2 m-1">刪除</p>
                                                <p class=" edit-btn btn btn-danger position-absolute top-0 start-0 fs-2 m-1">編輯</p>
                                                <div class='bg-info text-center my-auto text-danger fs-3 w-100 align-self-center todo-content'>${add_content}</div>
                                            </button>
                                        </div>`
                $('.cards').append(todo__template)
            }
        })
        // 動態新增：編輯、刪除、編輯完成、修改狀態
        $(document).on('click', '.del-btn', e => {
            e.target.closest('.card').remove()
        })
        $(document).on('click', '.edit-btn', e => {
            const edit_todo = e.target.closest('.card')
            const edit_todo_text = $(edit_todo).find('.todo-content').text()
            console.log(edit_todo)
            console.log(edit_todo_text)
            $(edit_todo).html(`
            <button type='button' id='input__button' class='todo bg-info d-flex h-100'>
                <p class="del-btn btn btn-danger position-absolute top-0 end-0 fs-2 m-1">刪除</p>
                <p class="edit-btn-done btn btn-danger position-absolute top-0 start-0 fs-2 m-1">完成</p>
                <input type='text' class='bg-info text-center my-auto text-danger fs-3 w-100 align-self-center edit-todo' name='add-content' placeholder='${edit_todo_text}'>
            </button>`) 
        })
        $(document).on('click', '.edit-btn-done', e => {
            const edit_todo = e.target.closest('.card')
            $(edit_todo).html(`
            <button type='button' id='input__button' class='todo bg-info d-flex h-100'>
                <p class="del-btn btn btn-danger position-absolute top-0 end-0 fs-2 m-1">刪除</p>
                <p class="edit-btn btn btn-danger position-absolute top-0 start-0 fs-2 m-1">編輯</p>
                <div class='bg-info text-center my-auto text-danger fs-3 w-100 align-self-center todo-content'>${$('.edit-todo').val()}</div>
            </button>`)
        })
        $(document).on('dblclick', '.card', e => {
            const undone_todo = e.target.closest('.card')
            $(undone_todo).toggleClass('undone') 
        })
        // 顯示切換、儲存、清空、讀取。
        $('.done-btn').click( e => {
            $('.card').show()
            $('.undone').hide()
        })
        $('.undone-btn').click( e => {
            $('.card').hide()
            $('.undone').show()
        })
        $('.all-btn').click( e => {
            $('.card').show()
        })
        $('.clear-btn').click( e => {
            $('.cards').html(
                `<div class='card bg-info m-2'>
                    <button type='button' id='input__button' class='todo bg-info d-flex h-100'>
                        <p class="add-btn btn btn-danger position-absolute top-0 end-0 fs-2 m-1">新增</p>
                        <input type='text' class='bg-info text-center my-auto text-danger fs-3 w-100 align-self-center' name='add-content' placeholder='Add Some Todo!'>
                    </button>
                </div>`)
        })
        $('.save-btn').click( e => {
            let todos = $('.card')
            let savedTodos = []
            let savedUid = (uid) ? uid : $('.uid').text() 
            
            for (let i = 1; i < todos.length; i++) {
                let todoStatus = null
                if ($(todos[i]).hasClass('undone')) {
                    todoStatus = 'undone'
                }
                savedTodos.push( { 
                    content: $(todos[i]).text().trim(),
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
                }).done(function(data) {
                    if (!data.ok) {
                        alert(data.message)
                        return
                    }
                    window.location = `http://mentor-program.co/mtr04group1/s22shadowl/week12/todos/index.php?uid=${savedUid}`
                })
            })
        $('.load-btn').click( e => {
            window.location = `http://mentor-program.co/mtr04group1/s22shadowl/week12/todos/index.php?uid=${$('.uid-input').val()}`
        })
        

    })
    
</script>
</head>
<body>
    <main class='container-fluid '>
        <div class='fs-1 text-start btn btn-info m-2'>TO DO LIST</div>
        <div class='rule text-start m-2'>
            說明：<br>
            1.輸入備忘後，點擊「新增」按鈕即可新增備忘。<br>
            2.雙擊備忘可將其標示為已完成。<br>
            3.點擊「刪除」按鈕可將其刪除。<br>
            4.點擊「修改」按鈕可將其刪除。<br>
            5.點擊「顯示全部」、「顯示未完成」、「顯示已完成」按鈕可切換顯示的待辦。<br>
            6.點擊「儲存待辦」後可儲存目前的待辦狀態，日後可以輸入 UID 以取得上次存入的待辦。<br>
            7.點擊「清空待辦」後可清空目前的待辦。
            <div class='bg-warning w-auto p-1 mt-2'>
                <div>
                    目前的UID：<span class='uid'><?php if ($_GET['uid']) {
                                                echo $_GET['uid'] ;
                                                } else { 
                                                echo $row['max'] + 1 ;
                                                    } ?>
                    </span>
                </div>
            輸入 UID：<input type='text' class='uid-input'><button class='load-btn btn btn-danger mx-2'>送出</button>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-warning bg-warning m-2">
            <div class="container-fluid">
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <div class="all-btn btn-danger btn mx-1">顯示全部</div>
                  </li>
                  <li class="nav-item">
                    <div class="undone-btn btn-danger btn mx-1">顯示未完成</div>
                  </li>
                  <li class="nav-item">
                    <div class="done-btn btn-danger btn mx-1">顯示已完成</div>
                  </li>
                  <li class="nav-item">
                    <div class="save-btn btn-danger btn mx-1 ">儲存待辦</div>
                  </li>
                  <li class="nav-item">
                    <div class="clear-btn btn-danger btn mx-1 ">清空待辦</div>
                  </li>
                </ul>
              </div>
            </div>
        </nav>
        <div class='cards d-flex flex-wrap'>
            <div class='card bg-info m-2 order-2'>
                <button type='button' id='input__button' class='todo bg-info d-flex h-100'>
                    <p class="add-btn btn btn-danger position-absolute top-0 end-0 fs-2 m-1">新增</p>
                    <input type='text' class='bg-info text-center my-auto text-danger fs-3 w-100 align-self-center' name='add-content' placeholder='Add Some Todo!'>
                </button>
            </div>
        </div>

    </main>

</body>
</html>