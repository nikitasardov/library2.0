<?php
//header('Content-type: text/html; charset=utf-8');
require_once("database.php");
require_once("models/functions.php");

$link = db_connect();
$books = get_all_books($link);
$book_authors = get_all_book_authors($link);

include("views/catalog.php");
?>
