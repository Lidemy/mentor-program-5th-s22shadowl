<?php 
    session_start();
    require_once('conn.php');
    require_once('utils.php');

    if (empty($_SESSION['username'])) {
        header("Location: index.php?errCode=2"); 
    }

    $stmt = $conn->prepare(
    "select * from s22shadowl_blog_users order by id desc "
    );
    $result = $stmt->execute();
    if(!$result) {
        die('Error:' . $conn->error);
    }
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>後台</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main class='board'>
        <div class='board__href'>
            <a class='left btn' href='index.php'>回主頁</a>
            <a class='right btn' href='logout.php'>登出</a>
        </div>
        <h1 class='board__title'>後台</h1>

            <div class='admin__panel'>
                <div>帳號：<?php echo escape($row['username']); ?> </div>

                <div class='user__nickname'>暱稱：<?php echo escape($row['nickname']); ?> 
                    <span class='update__nickname left btn'>編輯</span>
                </div>

                <div class='hide card__update__nickname'>
                    <form method='POST' action='handle_update_user.php'>
                            <input class='update__user__nickname' name='nickname' value='<?php echo escape($row['nickname']); ?>'></input>
                            <button class='btn' type='submit'>送出</button>
                    </form>
                </div>

                <div class='user__password'>密碼：******** 
                    <span class='update__password left btn'>編輯</span>
                </div>
                
                <div class='hide card__update__password'>
                    <form method='POST' action='handle_update_user.php'>
                            新密碼：<input class='update__user__password' name='password' type='password'></input>
                            <br>
                            密碼確認：<input class='update__user__passwordcheck' name='password_check' type='password'></input>
                            <button class='update__user__password__btn btn' type='submit'>送出</button>
                    </form>
                </div>

                <div class='user__aboutme'>關於我：<?php echo $row['about_me']; ?> 
                    <span class='update__aboutme left btn'>編輯</span>
                </div>

                <div class='hide card__update__aboutme'>
                    <form method='POST' action='handle_update_user.php'>
                        <button class='btn' type='submit'>送出</button>
                        <textarea class='update__user__aboutme' name='about_me'><?php echo escape($row['about_me']); ?></textarea>
                    </form>
                </div>

                <div class='user__photo'>大頭貼網址：<?php echo escape($row['photo_url']); ?> 
                    <span class='update__photo left btn'>編輯</span>
                </div>

                <div class='hide card__update__photo'>
                    <form method='POST' action='handle_update_user.php'>
                            <input class='update__user__photo' name='photo_url' value='<?php echo escape($row['photo_url']); ?>'></input>
                            <button class='btn' type='submit'>送出</button>
                    </form>
                </div>
            </div>
    </main>
    </body> 
    <script> 
        function showUpdateuserBox(updateButton, updateDiv) {
            document.querySelector(updateButton).addEventListener('click', function(e) {
            document.querySelector(updateDiv).classList.remove('hide')
            document.querySelector(updateButton).classList.add('hide')
            })
        }
        showUpdateuserBox('.update__nickname', '.card__update__nickname')
        showUpdateuserbox('.update__password', '.card__update__password')
        showUpdateuserBox('.update__aboutme', '.card__update__aboutme')
        showUpdateuserBox('.update__photo', '.card__update__photo')
        document.querySelector('.update__user__password__btn').addEventListener('click', function(e) {
            if (document.querySelector('update__password').value !== document.querySelector('.update__passwordcheck').value ) {
              e.preventDeafault()
              alert('輸入的密碼不相同')  
            } 
        }
</script>
</html>