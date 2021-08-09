<?php 
    require_once('conn.php');
    header('Content-type:application/json;charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    if (
        empty($_POST['uid']) ||
        empty($_POST['todos']) 
    ) {
        $json = array(
            "ok" => false,
            "message" => "Please check your todos!"
        );

        $response = json_encode($json);
        echo $response;
        die();
    }
 
    $userid = $_POST['uid'];
    $todos = $_POST['todos'];

    $sql = "INSERT INTO s22shadowl_todos(userid, todos)
    VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $userid, $todos);
    $result = $stmt->execute();

    if (!$result) {
        $json = array(
            "ok" => false,
            "message" => $conn->error
        );
        $response = json_encode($json);
        echo $response;
        die();
    }

    $json = array(
        "ok" => true,
        "message" => "success"
    );

    $response = json_encode($json);
    echo $response;
?>