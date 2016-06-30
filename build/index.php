<?php
    header('Content-type: text/html; charset=utf-8');
    require_once("database.php");
    require_once("models/functions.php");

    $link = db_connect();
    $books = get_books_all($link);
    //$books = get_books_all_old($link);

    include("views/catalog.php");
?>
