<?php
    require_once("database.php");
    require_once("models/functions.php");

    $link = db_connect();
    $books = books_all($link);

    $books = books_all($link);
    include("views/catalog.php");
?>