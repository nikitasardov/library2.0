<?php

require_once("../functions.php");
require_once("../database.php");
require_once("../session.php");

if (isset($_GET['action']))
    $action = $_GET['action'];
else
    $action = "";

if (isset($_GET['dbrefresh'])) {
    $_SESSION['active'] = false;
    header("Location: index.php");
}

if ($action == "add") {
    if (!empty($_POST)) {
        $new_book_id = books_add($_POST['title'], $_POST['description']);
        set_authors($new_book_id, $_POST['author']);
        $_SESSION['active'] = false;
        if (isset($_GET['admin'])) header("Location: index.php");
        else header("Location: ../index.php");

    }
    include("../views/book_add.php");


} elseif ($action == "edit") {
    if (!isset($_GET['id']))
        header("Location: index.php");
    $id = (int)$_GET['id'];

    if (!empty($_POST) && $id > 0) {
        edit_book($id, $_POST['title'], $_POST['description']);
        if ($_SESSION['current_book_authors'] != trim($_POST['author']))
            set_authors($id, $_POST['author']);
        $_SESSION['active'] = false;
        header("Location: index.php");
    }
    $book = show_book_details($books, $id);
    include("../views/book_edit.php");


} elseif ($action == "delete") {
    if (!isset($_GET['id']))
        header("Location: index.php");
    $id = (int)$_GET['id'];

    if (!empty($_POST) && ($id > 0) && ($_GET['confirm'] == 1)) {
        books_delete($id);
        $_SESSION['active'] = false;
        header("Location: index.php");
    }

    $book = show_book_details($books, $id);
    include("../views/book_delete.php");

} else {

    include("../views/catalog_admin.php");
}
?>
