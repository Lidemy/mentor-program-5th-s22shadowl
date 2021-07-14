<?php
  session_start();
  require_once('conn.php');
  require_once('utils.php');
  
  $user = $_SESSION['username'];

  if ( empty($user) ) {
    header('Location: index.php?errCode=2');
    die('權限錯誤');
  }

  if ( empty($_POST['nickname']) && 
       empty($_POST['password']) && 
       empty($_POST['about_me']) && 
       empty($_POST['photo_url']) 
       ) {
    header('Location: admin.php?errCode=1');
    die('資料不齊全');
  }
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $password_check = $_POST['password_check'];

  if ($_POST['nickname']) {
    $result = updateUserinfo('nickname', $_POST['nickname']);
  }
  if ($_POST['password'] = $_POST['password_check']) {
    $result = updateUserinfo('password', $password);
    $passchange = true;
    } 
  if ($_POST['about_me']) {
    $result = updateUserinfo('about_me', $_POST['about_me']);
  }
  if ($_POST['photo_url']) {
    $result = updateUserinfo('photo_url', $_POST['photo_url']);
  }
  if (!$result) {
    die($conn->error);
  }
  header("Location: admin.php");

  if($passchange) {
  header("Location: index.php?status=changepassword");
  }
?>