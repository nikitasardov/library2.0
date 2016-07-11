<?php
    require_once("functions.php");
    require_once("database.php");
    require_once("session.php");

    $book = get_book_details($books, $_GET['id']);
    include("views/book.php");
?>
