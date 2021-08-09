<?php 
require_once('conn.php');

if (!($_GET['uid'])) { 
    $stmt = $conn->prepare(
        'select max(userid) as max from s22shadowl_todos'
    );
    $result = $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    } 
?>
<!DOCTYPE html>

<html>
<head>
<meta charset="utf-8">
<title>TO DO LIST</title>
<meta name='viewport' content='width=device-width, initial-scale=1'> 
<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
<link rel='stylesheet' href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
<script src='script.js'>
</script>
</head>
<body>
    <main class='container-fluid '>
        <div class='fs-1 text-start btn btn-info m-2'>TO DO LIST</div>
        <div class='rule text-start m-2'>
            說明：<br>
            1.輸入備忘後，點擊「新增」按鈕即可新增備忘。<br>
            2.雙擊備忘可將其標示為已完成。<br>
            3.點擊「刪除」按鈕可將其刪除。<br>
            4.點擊「修改」按鈕可將其刪除。<br>
            5.點擊「顯示全部」、「顯示未完成」、「顯示已完成」按鈕可切換顯示的待辦。<br>
            6.點擊「儲存待辦」後可儲存目前的待辦狀態，日後可以輸入 UID 以取得上次存入的待辦。<br>
            7.點擊「清空待辦」後可清空目前的待辦。
            <div class='bg-warning w-auto p-1 mt-2'>
                <div>
                    目前的UID：<span class='uid'><?php if ($_GET['uid']) {
                                                echo $_GET['uid'] ;
                                                } else { 
                                                echo $row['max'] + 1 ;
                                                    } ?>
                    </span>
                </div>
            輸入 UID：<input type='text' class='uid-input'><button class='load-btn btn btn-danger mx-2'>送出</button>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-warning bg-warning m-2">
            <div class="container-fluid">
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <div class="all-btn btn-danger btn mx-1">顯示全部</div>
                  </li>
                  <li class="nav-item">
                    <div class="undone-btn btn-danger btn mx-1">顯示未完成</div>
                  </li>
                  <li class="nav-item">
                    <div class="done-btn btn-danger btn mx-1">顯示已完成</div>
                  </li>
                  <li class="nav-item">
                    <div class="save-btn btn-danger btn mx-1 ">儲存待辦</div>
                  </li>
                  <li class="nav-item">
                    <div class="clear-btn btn-danger btn mx-1 ">清空待辦</div>
                  </li>
                </ul>
              </div>
            </div>
        </nav>
        <div class='cards d-flex flex-wrap'>
            <div class='card bg-info m-2 order-2 input-todo'>
                <button type='button' id='input__button' class='todo bg-info d-flex h-100'>
                    <p class="add-btn btn btn-danger position-absolute top-0 end-0 fs-2 m-1">新增</p>
                    <input type='text' class='bg-info text-center my-auto text-danger fs-3 w-100 align-self-center' name='add-content' placeholder='Add Some Todo!'>
                </button>
            </div>
        </div>

    </main>

</body>
</html>