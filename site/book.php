<?php
    require_once("functions.php");
    require_once("session.php");

    $book = show_book_details($books, $_GET['id']);
    include("views/book.php");
?>
