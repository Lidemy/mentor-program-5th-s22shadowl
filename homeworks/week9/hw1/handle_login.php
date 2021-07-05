<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');
  if ( empty($_POST['username']) || empty($_POST['password']) ) {
    header('Location: login.php?errCode=1');
    die();
  }
  $username = $_POST['username'];
  $password = $_POST['password'];
  $sql = sprintf(
    "select * from s22shadowl_board_users where username='%s' and password='%s' ",
    $username,
    $password
  );
  $result = $conn->query($sql);
  if (!$result) {
    $code = $conn->errno;
    die($conn->error);
  }
  if ($result->num_rows) {
    $_SESSION['username'] = $username;
    header("Location: index.php?status=login");
  } else {
    header("Location: login.php?errCode=2");
  }
?>