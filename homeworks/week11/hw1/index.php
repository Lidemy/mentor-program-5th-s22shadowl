<?php 
    session_start();
    require_once('conn.php');
    require_once('utils.php');

    $username = NULL;
    $user = NULL;
    $authority = NULL;
    if (!empty($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $user = getUserFromUsername($username);
        $authority = $user['authority'];
    }    
    
    $page = 1;
    if (!empty($_GET['page'])) {
        $page = intval($_GET['page']);
    }
    $articles_per_page = 5;
    $offset = ($page -1) * $articles_per_page;

    $stmt = $conn->prepare("select " .
                            'C.id as id, '. 
                            'C.content as content, ' .
                            'C.title as title, ' .
                            'C.created_at as created_at, ' .
                            'U.nickname as nickname, ' .
                            'U.username as username, ' .
                            'U.authority as authority ' .
                            'from s22shadowl_board_comments as C '.
                            'left join s22shadowl_board_users as U on C.username = U.username ' .
                            'where C.is_deleted IS NULL '.
                            'order by C.id desc '.
                            'limit ? offset ? '
                        );

    $stmt->bind_param('ii', $articles_per_page, $offset);
    $result = $stmt->execute();
    if(!$result) {
        die('Error:' . $conn->error);
    }
    $result = $stmt->get_result();
    if (!empty($_GET['status'])) { // 這裡處理登入和登出的 alert 寫了很久一直有問題，最後才發現是 PHP 執行順序高於 JS 造成的。
        $status = $_GET['status'];
        switch ($status) {
            case 'login': {
                echo "<script>alert('登入成功')</script>";
                break;
            }  
            case 'logout': {
                echo "<script>alert('登出成功')</script>"; 
                break;
            }
            case 'register': {
                echo "<script>alert('註冊成功')</script>";     
                break;
            }
        }
        echo "<script>window.location.href='index.php'</script>";
    } 
?>

<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Acmiko</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class='warning'>
        <strong>注意！本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼。</strong>
    </header>
    <div class='bar'>
        <h3 class='bar__title'>ACMIKO</h3>
        <ul>
            <li>測試1</li>
            <li>測試1</li>
            <li>測試1</li>
            <li>測試1</li>
            <li>測試123</li>
        </ul>
    </div>
    <main class='board'>
        <div class='board__href' >
            <?php if(!$username) { ?>
                [<a href='register.php'>註冊</a>]
                [<a href='login.php'>登入</a>]
                <?php } else { 
                  if($authority == 1) { ?>
                [<a href='admin.php'>後台</a>]
                <?php } ?>
                [<a href='logout.php'>登出</a>]
                <h3>你好！ <?php echo escape($user['nickname']); ?></h3>
            <?php } ?>
        </div>
        <h1 class='board__title'>綜合留言板</h1>
        <hr>
        <hr>
        <?php 
            if (!empty($_GET['errCode'])) {
                $code = $_GET['errCode'];
                $msg = 'Error';
                if ($code === '1') {
                    $msg = '資料不齊全';
                } else if ($code === '2') {
                    $msg = '權限錯誤';
                }
                echo '<h2 class="error">錯誤：' . $msg .'</h2>';
            }
        ?>
        <form class='board__new-comment-form' method='POST' action='handle_add_comment.php' id='new-comment'></form>
            <div>
                <table>
                    <tr class='nickname-column'>
                        <td>暱稱</td>
                        <td><span class ='input__username'><?php if ($username) { echo escape($user['nickname']); ?></span>
                            [<span class='edit-nickname-btn'>編輯暱稱</span>]<?php } ?></td>
                    </tr>
        <form method='POST' action='update_user.php'>
                    <tr class='hide update-nickname-form'>
                        <td>暱稱</td>
                        <td><input type='text' name='nickname' value='<?php echo escape($user['title']); ?>'/><button class='submit-nickname-btn'type='submit'>送出</button></form></td>
                    </tr>
                    <tr>
                        <td>標題</td>
                        <td><input class='input__title'name='title' form='new-comment'></input></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>內文</td>
                        <td><textarea class='input__content'name='content' rows='5' form='new-comment'></textarea></td>
                        <td></td>
                    </tr>
                </table>
                <?php if($username) { 
                    if($authority >= 0 ) {?>
                    <div class='board__submit'><input class='board__submit-btn' type='submit' value='送出' form='new-comment'/></div>
                <?php } else { ?>
                <div class='login__hint'>你的帳號已被限制發言</div>
                <?php }} else { ?>
                <div class='login__hint'>請登入以發布留言</div>
                <?php } ?>
            </div>
        <hr>
        <div class='board__hr'></div>
        <section class='board_comments'>
        <?php while($row = $result->fetch_assoc()) { ?>
            <div class='card'>
                <div class='card__body'>
                    <div class='card__info'>
                        <span class='card__title'>
                            <?php echo escape($row['title']); ?>
                        </span>
                        <span class='card__author'>
                            <?php echo escape($row['nickname']. '(' . $row['username'] .')'); ?>
                        </span>
                        <span class='card__time'>
                            <?php echo escape($row['created_at']); ?>
                        </span>
                        <?php if ($row['username'] === $username || $authority > 0) { ?>
                            [<a class='delete__comments-btn' href='delete_comment.php?id=<?php echo escape($row['id']) ?>'>刪除</a>]
                            [<span class='update__comments-btn' data-commentsid='<?php echo escape($row['id']) ?>'>編輯</span>]
                        <?php } ?>
                    </div>
                    <p class='card__content'><?php echo escape($row['content']); ?></p>
                    <div class='hide card__update__comments' data-commentsid='<?php echo escape($row['id']) ?>'>
                        <form method='POST' action='handle_update_comment.php?id=<?php echo escape($row['id'])?>'>
                            <input type="hidden" name="id" value="<?php echo $row['id'] ?>" />
                            <table>
                                <tr>
                                    <td>標題</td>
                                    <td><input class='update__comments__title' name='title' value='<?php echo escape($row['title']); ?>'></input><button type='submit'>送出</button></td>
                                </tr>
                                <tr>
                                    <td>內文</td>
                                    <td><textarea class='update__comments__content'name='content' rows='5'><?php echo escape($row['content']);?></textarea><td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <hr>
        <?php } ?>
        </section>
        <div class='board__hr'></div>
        <?php 
        $stmt = $conn->prepare(
            'select count(id) as count from s22shadowl_board_comments where is_deleted IS NULL'
        );
        $result = $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];
        $total_page =  ceil($count / $articles_per_page);
        ?>
        <div class="page-info">
            <span>總共有 <?php echo escape($count) ?> 筆留言，頁數：</span>
            <span><?php echo escape($page) ?> / <?php echo escape($total_page) ?></span>
        </div>
        <div class="paginator">
        <?php if ($page != 1) { ?> 
            <a href="index.php?page=1">首頁</a>
            <a href="index.php?page=<?php echo $page - 1 ?>">上一頁</a>
        <?php } ?>
        <?php for($print_page = 1; $print_page <= $total_page; $print_page++) { if ($print_page == $page) {?>
                <span>[<?php echo escape($print_page) ?>]</span>
            <?php } else { ?>
                <a href="index.php?page=<?php echo $print_page ?>">[<?php echo escape($print_page) ?>]</a>
            <?php }} ?>

        <?php if ($page != $total_page) { ?>
            <a href="index.php?page=<?php echo $page + 1 ?>">下一頁</a>
            <a href="index.php?page=<?php echo $total_page ?>">最後一頁</a> 
        <?php } ?>
        </div>
    </main>
</body>
<script>
    let edit_btn = document.querySelector('.edit-nickname-btn')
    let submit_btn = document.querySelector('.submit-nickname-btn')
    let form = document.querySelector('.update-nickname-form')
    let nickname_column = document.querySelector('.nickname-column')
    edit_btn.addEventListener('click', function() {
        form.classList.remove('hide')
        nickname_column.classList.add('hide')
    })
    submit_btn.addEventListener('click', function() {
        form.classList.add('hide')
        nickname_column.classList.remove('hide')
    })

    document.querySelector('.board_comments').addEventListener('click', function(e) {
        if (e.target.classList.contains('update__comments-btn')) {
            let all_box = document.querySelectorAll('.card__update__comments')
            for (let i=0; i< all_box.length; i++) {
                if ( all_box[i].dataset.commentsid === e.target.dataset.commentsid) {
                    all_box[i].classList.remove('hide')
                }
            }
        }    
    })
</script>
</html>