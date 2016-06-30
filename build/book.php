<?php
    require_once("database.php");
    require_once("models/functions.php");

    $link = db_connect();
    $book = get_book($link, $_GET['id']);

    include("views/book.php");
?>
