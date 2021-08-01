<?php 
    session_start();
    require_once('conn.php');
    require_once('utils.php');

    if (empty($_GET['id'])) {
        header('Location: index.php?errCode=1');
        die('頁面錯誤');
      }

    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT title, id, content, created_at FROM s22shadowl_blog_articles WHERE id=?");
    $stmt->bind_param('i', $id);
    $result = $stmt->execute();
    if(!$result) {
        die('Error:' . $conn->error);
    }
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $user = NULL;
    if (!empty($_SESSION['username'])) {
        $user = $_SESSION['username'];
    }

?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo escape($row['title']); ?></title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main class='board'>
        <div class='board__href'>
            <a class='left btn' href='index.php'>回主頁</a>
            <?php if(!$user) { ?>
                <a class='right btn' href='login.php?id=<?php echo escape($row['id']); ?>'>登入</a> 
                <?php } else { ?>              
                <a class='right btn' href='logout.php'>登出</a>
            <?php } ?>
        </div>
        <div class='article'>
            <div class='article__title'>
                <?php if($user) { ?>
                        <a class='delete__articles right btn' href='delete_article.php?id=<?php echo escape($row['id']); ?>'>刪除</a>
                        <span class='update__title left btn'>編輯</span>
                <?php } ?> 
                <?php echo escape($row['title']); ?>
            </div>
            <div class='hide card__update__title'>
            <form method='POST' action='handle_update_article.php?id=<?php echo $row['id']?>'>
                        <input type="hidden" name="id" value="<?php echo $row['id'] ?>" />
                        <input class='update__articles__title' name='title' value='<?php echo escape($row['title']); ?>'></input>
                        <button type='submit' class='left btn'>送出</button>
            </form>
            </div>
            <div class='article__content'>
            <?php if($user) { ?>
            <span class='update__content left btn'>編輯</span>
            <?php } ?>
                <p class='article__time'>建立於：<?php echo $row['created_at']; ?></p>
                <p><?php echo $row['content']; ?></p>
            </div>
            <div class='hide card__update__content'>
                        <form method='POST' action='handle_update_article.php?id=<?php echo escape($row['id'])?>'>
                            <input type="hidden" name="id" value="<?php echo escape($row['id']) ?>" />
                            <textarea class='update__articles__content'name='content' rows='20'><?php echo escape($row['content']);?></textarea>
                            <button type='submit' class='left btn'>送出</button>
                        </form>
                    </div>
        </div>
        
    </main>
</body>
<script>
    document.querySelector('.update__title').addEventListener('click', function(e) {
        document.querySelector('.card__update__title').classList.remove('hide')
        document.querySelector('.article__title').classList.add('hide')
    })
    document.querySelector('.update__content').addEventListener('click', function(e) {
        document.querySelector('.card__update__content').classList.remove('hide')
        document.querySelector('.article__content').classList.add('hide')
    })
</script>
</html>