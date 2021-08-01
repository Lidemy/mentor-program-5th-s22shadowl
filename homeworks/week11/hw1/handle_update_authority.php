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
  if (empty($_POST['id'])) {
    header('Location: index.php?errCode=1');
    die('資料不齊全');
  }

  $id = $_POST['id'];
  $authorityuser = 'authority' . $id;
  $authority = $_POST['authority' . $id];

  $sql = "update s22shadowl_board_users set authority=? where id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ii', $authority, $id);
  $result = $stmt->execute();
  if (!$result) {
    die($conn->error);
  }
  header("Location: admin.php");
?>