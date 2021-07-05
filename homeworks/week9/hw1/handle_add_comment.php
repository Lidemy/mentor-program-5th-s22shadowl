<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');

  if ( empty($_POST['title']) || empty($_POST['content']) ) {
    header('Location: index.php?errCode=1');
    die('資料不齊全');
  }
  $user = getUserFromUsername($_SESSION['username']);
  $username = $_SESSION['username'];
  $nickname = $user['nickname'];
  $content = $_POST['content'];
  $title = $_POST['title'];

  $sql = sprintf(
    "insert into s22shadowl_board_comments(username, nickname, title, content) values('%s', '%s', '%s', '%s')",
    $username,
    $nickname,
    $title,
    $content
  );
  $result = $conn->query($sql);
  if (!$result) {
    die($conn->error);
  }
  header("Location: index.php");
?>