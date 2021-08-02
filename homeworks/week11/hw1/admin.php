<?php 
    session_start();
    require_once('conn.php');
    require_once('utils.php');

    if (!empty($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $user = getUserFromUsername($username);
    } else { // 身分驗證：權限不足
        header("Location: index.php?errCode=2"); // 無登入者
    }

    if ( $user['authority'] != 1 ) {  
        header("Location: index.php?errCode=2"); // 身分組不符
    }

    $page = 1;
    if (!empty($_GET['page'])) {
        $page = intval($_GET['page']);
    }
    $articles_per_page = 5;
    $offset = ($page -1) * $articles_per_page;

    $stmt = $conn->prepare(
    "SELECT username, authority, id FROM s22shadowl_board_users ORDER BY id DESC ".
    "limit ? offset ? "
    );
    $stmt->bind_param('ii', $articles_per_page, $offset);
    $result = $stmt->execute();
    if(!$result) {
        die('Error:' . $conn->error);
    }
    $result = $stmt->get_result();

?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>後台</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class='warning'>
        <strong>注意！本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼。</strong>
    </header>
    <main class='board'>
        <div class='board__href'>
            [<a href='index.php'>回留言板</a>]
            [<a href='logout.php'>登出</a>]
        </div>
        <h1 class='board__title'>後台</h1>

        <table class='table'>
            <tr>
                <td>ID</td>
                <td>帳號</td>
                <td>權限</td>
                <td>管理權限</td>
        <?php while($row = $result->fetch_assoc()) { ?>
            <tr class='table_tr'>
                <td><?php echo escape($row['id']); ?></td>
                <td><?php echo escape($row['username']); ?></td>
                <td><?php if ( $row['authority'] === 0 ) { 
                    echo '一般使用者'; } 
                    else if ( $row['authority'] === 1 ) { 
                    echo '管理員';} 
                    else { echo '限制使用者'; } ?></td>
                <td>
                    <form method='POST' action='handle_update_authority.php?id=<?php echo $row['id']?>'>
                        <input type="hidden" name="id" value="<?php echo $row['id'] ?>" />
                        <input type="radio" name="authority<?php echo escape($row['id'])?>" value="1" <?php if ( $row['authority'] === 1 ) { echo 'checked'; }?> /> 管理員
                        <input type="radio" name="authority<?php echo escape($row['id'])?>" value="0" <?php if ( $row['authority'] === 0 ) { echo 'checked'; }?> /> 一般使用者
                        <input type="radio" name="authority<?php echo escape($row['id'])?>" value="-1" <?php if ( $row['authority'] === -1 ) { echo 'checked'; }?> /> 限制使用者</input>
                        <button type='submit'>修改</button>
                </td>
                    </form>
            </tr>
        <?php } ?>
        </table>
        <?php // 後台分頁
        $stmt = $conn->prepare(
            'select count(id) as count from s22shadowl_board_users'
        );
        $result = $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $count = $row['count'];
        $total_page =  ceil($count / $articles_per_page);
        ?>
        <div class='board__hr'></div>
        <div class="admin-page">
            <div class="page-info">
                <span>總共有 <?php echo escape($count) ?> 個帳號，頁數：</span>
                <span><?php echo escape($page) ?> / <?php echo escape($total_page) ?></span>
            </div>
            <div class="paginator">
            <?php if ($page != 1) { ?> 
                <a href="admin.php?page=1">首頁</a>
                <a href="admin.php?page=<?php echo $page - 1 ?>">上一頁</a>
            <?php } ?>
            <?php for($print_page = 1; $print_page <= $total_page; $print_page++) { if ($print_page == $page) {?>
                <span>[<?php echo escape($print_page) ?>]</span>
            <?php } else { ?>
                <a href="admin.php?page=<?php echo $print_page ?>">[<?php echo escape($print_page) ?>]</a>
            <?php }} ?>
                
            <?php if ($page != $total_page) { ?>
                <a href="admin.php?page=<?php echo $page + 1 ?>">下一頁</a>
                <a href="admin.php?page=<?php echo $total_page ?>">最後一頁</a> 
            <?php } ?>
            </div>
        </div>
    </main>
</body>
</html>