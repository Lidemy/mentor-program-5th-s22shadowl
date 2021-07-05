<?php 
    session_start();
    require_once('conn.php');
    require_once('utils.php');

    $username = NULL;
    if (!empty($_SESSION['username'])) {
        $username = $_SESSION['username'];
    }    
    
    $result = $conn->query("select * from s22shadowl_board_comments order by id desc");
    if(!$result) {
        die('Error:' . $conn->error);
    }
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
            <li>測試1</li>
        </ul>
    </div>
    <main class='board'>
        <div class='board__href' >
            <?php if(!$username) { ?>
                [<a href='register.php'>註冊</a>]
                [<a href='login.php'>登入</a>]
            <?php } else { ?>
                [<a href='logout.php'>登出</a>]
                <h3>你好！ <?php echo $username; ?></h3>
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
                }
                echo '<h2 class="error">錯誤：' . $msg .'</h2>';
            }
        ?>
        <form class='board__new-comment-form'method='POST' action='handle_add_comment.php'>
            <div>
                <table>
                    <tr>
                        <td>帳號</td>
                        <td><div class ='input__username'><?php echo $username; ?></div></td>
                    </tr>
                    <tr>
                        <td>標題</td>
                        <td><input class='input__title'name='title'></input></td>
                    </tr>
                    <tr>
                        <td>內文</td>
                        <td><textarea class='input__content'name='content' rows='5'></textarea></td>
                    </tr>
                </table>
                <?php if($username) { ?>
                    <input class='board__submit-btn' type='submit' value='送出'/>
                <?php } else { ?>
                <div class='login__hint'>請登入以發布留言</div>
                <?php } ?>
            </div>
        </form>
        <hr>
        <div class='board__hr'></div>
        <section>
        <?php while($row = $result->fetch_assoc()) { ?>
            <div class='card'>
                <div class='card__body'>
                    <div class='card__info'>
                        <span class='card__title'>
                            <?php echo $row['title']; ?>
                        </span>
                        <span class='card__author'>
                            <?php echo $row['nickname']. '(' . $row['username'] .')'; ?>
                        </span>
                        <span class='card__time'>
                            <?php echo $row['created_at']; ?>
                        </span>
                    </div>
                    <p class='card__content'><?php echo $row['content']; ?></p>
                </div>
            </div>
            <hr>
        <?php } ?>
        </section>
    </main>
</body>
</html>