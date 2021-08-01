<?php 
    require_once('conn.php');
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>登入</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class='warning'>
    </header>
    <main class='board'>
        <div class='board__href'>
            <a class='right btn' href='index.php'>回首頁</a>
        </div>
        <h1 class='board__title'>登入</h1>
        <?php 
            if (!empty($_GET['errCode'])) {
                $code = $_GET['errCode'];
                $msg = 'Error';
                if ($code === '1') {
                    $msg = '資料不齊全';
                } else if ($code === '2') {
                    $msg = '帳號或密碼輸入錯誤';
                }
                echo '<h2 class="error">錯誤：' . $msg .'</h2>';
            }
        ?>
        <form class='board__new-comment-form'method='POST' action='handle_login.php<?php if(!empty($_GET['id'])) { echo "?id=". $_GET['id'] ; }?>'>
            <div class='board__login'>
                <span>帳號：</span>
                <input type='text' name='username' />
            </div>
            <div class='board__login'>
                <span>密碼：</span>
                <input type='password' name='password' />
                <input class='board__submit btn' type='submit' value='登入'/>
            </div>
        </form>
    </main>
</body>
</html>