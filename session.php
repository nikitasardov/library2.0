<?php
session_start();

if (!isset($_SESSION['active']) || ($_SESSION['active'] == false)) {

    $_SESSION['link'] = db_connect();
    $link = $_SESSION['link'];

    $_SESSION['books'] = get_all_books(); //на входе функции переменная $_SESSION['link']
    $books = $_SESSION['books'];

    $_SESSION['book_authors'] = get_all_book_author_relations();  //на входе функции $_SESSION['link']
    $book_authors = $_SESSION['book_authors'];
    $_SESSION['active'] = true;
    echo '<div style="color:red;">session restarted, variables refreshed</div>';
    //echo '<div style="color:green;">$link = '.$link.'</div>';
    //echo $_SESSION['link'];
} else {
    $link = $_SESSION['link'];
    $books = $_SESSION['books'];
    $book_authors = $_SESSION['book_authors'];
    echo '<div style="color:green;">session active</div>';
    //echo '<div style="color:green;">link = '.$link.'</div>';
}
?>