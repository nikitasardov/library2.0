<?php
    require_once("../database.php");
    require_once("../models/functions.php");

    $link = db_connect();

    if(isset($_GET['action']))
        $action = $_GET['action'];
        else
        $action = "";

    if($action == "add") {
        if(!empty($_POST)){
            books_add($link, $_POST['title'], $_POST['author'], $_POST['description']);
            if (isset($_GET['admin'])) header("Location: index.php");
            else header("Location: ../index.php");

        }
        include("../views/book_add.php");



    } elseif ($action == "edit") {
        if(!isset($_GET['id']))
            header("Location: index.php");
        $id = (int)$_GET['id'];

        if(!empty($_POST) && $id > 0){
            edit_book($link, $id, $_POST['title'], $_POST['author'], $_POST['description']);
            header("Location: index.php");
        }
        $book = get_book($link, $id);
        include("../views/book_edit.php");



    } elseif ($action == "delete") {
        if(!isset($_GET['id']))
            header("Location: index.php");
        $id = (int)$_GET['id'];

        if(!empty($_POST) && ($id > 0) && ($_GET['confirm'] == 1)){
            books_delete($link, $id);
            header("Location: index.php");
        }

        $book = get_book($link, $id);
        include("../views/book_delete.php");

    } else {
        $books = get_books_all($link);
        include("../views/catalog_admin.php");
    }
?>
