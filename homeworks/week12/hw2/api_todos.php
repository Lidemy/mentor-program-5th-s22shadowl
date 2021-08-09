<?php 
    require_once('conn.php');
    header('Content-type:application/json;charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    if (
        empty($_GET['uid']) 
    ) {
        $json = array(
            "ok" => false,
            "message" => "Please add uid in url"
        );

        $response = json_encode($json);
        echo $response;
        die();
    };

    $uid = $_GET['uid'];

    $sql = "SELECT todos FROM s22shadowl_todos WHERE userid = ? ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $uid);
    $result = $stmt->execute();

    if (!$result) {
        $json = array(
            "ok" => false,
            "message" => $conn->error
        );
        $response = json_encode($json);
        echo $response;
        die();
    };

    $result = $stmt->get_result();
    $todos = array();
    while($row = $result->fetch_assoc()) {
        array_push($todos, array(
            "todos" => $row['todos']
        ));
    }

    $json = array(
        "ok" => true,
        "todos" => $todos
    );

    $response = json_encode($json);
    echo $response;
?>