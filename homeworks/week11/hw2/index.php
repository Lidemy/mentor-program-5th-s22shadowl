<?php 
    session_start();
    require_once('conn.php');
    require_once('utils.php');

    $user = NULL;
    if (!empty($_SESSION['username'])) {
        $user = $_SESSION['username'];
    }    
    
    $page = 1;
    if (!empty($_GET['page'])) {
        $page = intval($_GET['page']);
    }
    $articles_per_page = 5;
    $offset = ($page -1) * $articles_per_page;

    $stmt = $conn->prepare("select " .
                            'id, '. 
                            'content, ' .
                            'title ' .
                            'from s22shadowl_blog_articles '.
                            'where is_deleted IS NULL '.
                            'order by id desc '.
                            'limit ? offset ? '
                        );

    $stmt->bind_param('ii', $articles_per_page, $offset);
    $result = $stmt->execute();
    if(!$result) {
        die('Error:' . $conn->error);
    }
    $result = $stmt->get_result();
    if (!empty($_GET['status'])) { 
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
            case 'changepassword': {
                echo "<script>alert('密碼更換成功，請重新登入')</script>";
                session_destroy(); 
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
  <title>一個極簡部落格</title>
  <link rel="stylesheet" href="style.css">
  <link rel='stylesheet' herf='https://necolas.github.io/normalize.css/8.0.1/normalize.css' />
                 
</head>

<body>
    <main class='board'>
        <div class='board__header'>
            <span class='board__title'>一個極簡部落格</span>
            <span class='board__href' >
            <?php if(!$user) { ?>
                <a class='right btn' href='login.php'>登入</a>
                <?php } else { ?>              
                <a class='right btn' href='logout.php'>登出</a>
            <?php } ?>
            </span>
        </div>
            <div>
            </div>
        <section class='board__comments'>
        <?php while($row = $result->fetch_assoc()) { ?>
            <div class='card'>
                <a href='article.php?id= <?php echo escape($row['id']); ?>'>
                <div class='card__body'>
                    <div class='card__info'>
                        <span class='card__title'>
                            <?php echo escape($row['title']); ?>
                        </span>
                    </div>
                    <p class='card__content'><?php echo escape($row['content']); ?></p>
                </div>
                </a>
            </div>
        <?php } ?>
        </section>
        <?php 
            $stmt = $conn->prepare(
                'select count(id) as count from s22shadowl_blog_articles where is_deleted IS NULL'
            );
            $result = $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $count = $row['count'];
            $total_page =  ceil($count / $articles_per_page);
            ?>
        <?php if($page != 1) { ?>
        <span class='left btn'><a href="index.php?page=<?php echo escape($page - 1) ?>">向前</a></span>
        <?php } ?>
        <?php if($page != $total_page) { ?>
        <span class='right btn'><a href="index.php?page=<?php echo escape($page + 1) ?>">向後</a></span>
        <?php } ?>
        <div class='board__panel'>
            <div class='user__brief'>
            <?php
            $stmt = $conn->prepare('select ' .
                            'nickname, ' .
                            'username, '.
                            'photo_url, '.
                            'about_me ' .
                            'from s22shadowl_blog_users '
                        );
            $result = $stmt->execute();
            if(!$result) {
            die('Error:' . $conn->error);
            }
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            ?>
                <img class='user__photo' src='<?php echo escape($row['photo_url']) ?>'>
                <div class='user__account'>
                    <div><?php echo escape($row['nickname']); ?></div>
                    <div>@<?php echo escape($row['username']) ?></div>
                </div>
                <?php if ($user) { ?>
                <span class='admin btn'><a href="admin.php">後台</a></span>
                <?php } ?>                
            </div>
            <div class='user__info'>
                <div>關於我： <?php echo escape($row['about_me']); ?></div>
            </div>
            <div class='user__new__article'>
                <?php if ($user) {?>
                <form class='input' method='POST' action='handle_add_article.php'>
                    <input class='input__title' type='text' name='title' value='請輸入標題'/>
                    <button class='submit-article btn'type='submit'>發表</button>
                    <br>
                    <textarea class='input__content'name='content'>請輸入內文</textarea>
                </form>
                <?php } ?>
            </div>
            <div class='user__links'>
                <div class='list__articles'>
                    <form method='get' action='article.php'>
                    <select name='id'>
                        <option>文章列表：總共有 <?php echo escape($count) ?> 篇文章</option>
                        <?php                
                        $stmt = $conn->prepare("select " .
                                            'id, '. 
                                            'title ' .
                                            'from s22shadowl_blog_articles '.
                                            'where is_deleted IS NULL '.
                                            'order by id desc '                                            
                                        );

                        $result = $stmt->execute();
                        if(!$result) {
                        die('Error:' . $conn->error);
                        }
                        $result = $stmt->get_result();
                        $num= $count;
                        while($row = $result->fetch_assoc()) { ?>
                            <option value='<?php echo escape($row['id']); ?>'>
                                <?php echo escape($num); ?>.
                                <?php echo escape($row['title']); ?>
                            </option>
                        <?php $num--; } ?>
                    </select>
                    <input type="submit" value="確認">
                    </form>
                </div>
                
                <div class='list__tags'>
                    <select name='tag'>
                    <option>以標籤檢視文章：尚未實作</option>
                    <input type="submit" value="確認">
                    </select>
                </div>
            </div>
        </div>
    </main>
</body>
<script>

</script>
</html>