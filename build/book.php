<?php
    require_once("database.php");
    require_once("models/functions.php");

    $link = db_connect();
    $book = books_get_old($link, $_GET['id']);

    include("views/book.php");
?>
