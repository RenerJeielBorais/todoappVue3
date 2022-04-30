<?php
header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Methods: POST, GET, PUT");
header("Access-Control-Allow-Headers: Content-Type");


require_once('MysqliDb.php');
$db = new MysqliDb('localhost', 'root', '', 'todo');
$request = json_decode(file_get_contents("php://input"));

// Check connection
//if ($db->connect_error) {
//    die('Connection failed: ' . $db->connect_error);
//} else {
//   echo "Connected successfully";
//  }

if ($request != null) {
    $id = $request->id;
    $title = $request->title;
    $description = $request->description;
    $status = $request->status;
}

$result = array('error' => false);
$run = '';

if (isset($_GET['run'])) {
    $run = $_GET['run'];
}


if ($run == "read") {
    $show = array("id", "title", "description", "status");
    $todos = $db->get("todo", null, $show);
    if ($db->count > 0)
        foreach ($todos as $todo) {
            $result['todo'] = $todos;
        }
    echo (json_encode($result));
}

if ($run == "delete") {
    $db->where('id', $id);
    if ($db->delete('todo')) echo 'successfully deleted';
}

if ($run == "add") {
    if ($request != null) {
        $data = array("title" => "$title", "description" => "$description", 'status' => "$status");
        $db->insert('todo', $data);
    }
}

if ($run == "update") {
    $db->where('id', $id);
    $data = array('title' => "$title", 'description' => "$description", 'status' => "$status");
    $db->where('id', $id);
    if ($db->update('todo', $data))
        echo $db->count . ' db updated';
    else
        echo 'update failed: ' . $db->getLastError();
}

if ($run == "status") {
    $db->where('id', $id);
    $data = array(
        'status' => "$status",
    );
    $db->where('id', $id);
    if ($db->update('todo', $data))
        echo $db->count . ' db updated';
    else
        echo 'update failed: ' . $db->getLastError();
}
