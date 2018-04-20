<?php

session_start();

if (!isset($_SESSION['items']) ) {
    $_SESSION['items'] = array();
}

$action = $_REQUEST['action'];

function printItems () {
    echo json_encode($_SESSION['items']);
}

if ($action == 'list') {
    sleep(1);
    printItems();
} else if ($action == 'list-static') {
    sleep(1);
    echo json_encode(array(
        array('id' => 1, 'name' => 'Learn JS'),
        array('id' => 2, 'name' => 'Learn CSS'),
        array('id' => 3, 'name' => 'Learn how to poo'),
    ));
} else if ($action == 'add') {
    if (isset($_POST['name'])) {
        array_unshift( $_SESSION['items'], array(
            'id' => uniqid(),
            'name' => $_POST['name']
        ));
        sleep(1);
        printItems();
    } else {
        header('HTTP/1.1 500 Internal Server Silly');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'name is required', 'code' => 1)));
    }
} else if ($action == 'delete') {
    if (isset($_GET['id'])) {
        foreach ($_SESSION['items'] as $key => $item) {
            if ($item['id'] === $_GET['id']) {
                unset($_SESSION['items'][$key]);
                printItems();
                exit;
            }
        }
    } else {
        header('HTTP/1.1 500 Internal Server Booboo');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'id is required', 'code' => 1)));
    }
} else if ($action == 'clear') {
    $_SESSION['items'] = array();
    printItems();
}


?>