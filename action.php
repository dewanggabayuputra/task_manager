<?php
    include 'config.php';
    include 'controller.php';
    $database = new database();
	$controller = new controller($database->con);
    
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    //flag action type
    if($action == "create"){    
        $controller->create($_POST['title'],$_POST['description']);
    }elseif($action == "delete"){ 	
        $controller->delete($_GET['id']);
    }elseif($action == "update"){
        $controller->update($_POST['id'],$_POST['status']);
    }
?>