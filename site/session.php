<?php
session_start();

if (!isset($_SESSION['active']) || ($_SESSION['active'] == false)) {
    require_once("database.php");
    $_SESSION['link'] = db_connect();
    $link = $_SESSION['link'];

    $_SESSION['books'] = get_all_books(); //на входе функции $_SESSION['link']
    $books = $_SESSION['books'];

    $_SESSION['book_authors'] = get_all_book_authors();  //на входе функции $_SESSION['link']
    $book_authors = $_SESSION['book_authors'];
    $_SESSION['active'] = true;
} else {
    $link = $_SESSION['link'];
    $books = $_SESSION['books'];
    $book_authors = $_SESSION['book_authors'];
}
?>