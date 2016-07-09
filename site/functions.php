<?php

/*
function get_all_data($link) //в разработке, не используется
{
    //запрос
    $query = "SELECT * FROM books, book_author, authors, ganres WHERE books.ID = book_author.BOOK_ID AND book_author.BOOK_ID = authors.AUTHOR_ID AND books.GANRE_ID = ganres.GANRE_ID ORDER BY ID DESC"; //выбираем все (*) из таблиц books, book_author, authors, ganres сортируем (ORDER) по id  в обратном порядке (DESC)
    $result = mysqli_query($link, $query);

    if (!$result)
        die(mysqli_error($link)); //если ошибка, останавливаем скрипт и выводим ошибку

    //Извлечение из БД
    $n = mysqli_num_rows($result); //кол-во строк в базе
    $books = array(); //создаем пустой массив

    for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $books[] = $row;
    }

    return $books;
}
*/

function get_all_books()
{
    //запрос
    $query = "SELECT * FROM books ORDER by ID DESC "; //выбираем все (*) из таблицы books, сортируем (ORDER) по id  в обратном порядке (DESC)
    $result = mysqli_query($_SESSION['link'], $query);

    if (!$result)
        die(mysqli_error($_SESSION['link'])); //если ошибка, останавливаем скрипт и выводим ошибку

    //Извлечение из БД
    $n = mysqli_num_rows($result); //кол-во строк в базе
    $books = array(); //создаем пустой массив

    for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $books[] = $row;
    }

    return $books;
}

function show_book_details($books, $id_book)
{
    foreach ($books as $current_book) {
        if ($current_book['ID'] == $id_book) {
            $book = $current_book;
            break;
        }
    }
    return $book;
}


function get_all_book_author_relations() //query!!получить все связи книга-автор. вызывается при загрузке "библиотеки", результаты хранятся в массиве $book_authors Не требуется напрягать базу, когда нужно получить список авторов для конкретной книги
{
    $query = "SELECT * FROM book_author, authors WHERE book_author.AUTHOR_ID = authors.AUTHOR_ID"; //выбираем все отношения книга-автор
    $result = mysqli_query($_SESSION['link'], $query);

    if (!$result)
        die(mysqli_error($_SESSION['link'])); //если ошибка, останавливаем скрипт и выводим ошибку

    //Извлечение из БД
    $n = mysqli_num_rows($result); //кол-во строк в результате запроса
    $book_authors = array(); //создаем пустой массив

    for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $book_authors[] = $row;
    }

    return $book_authors;

}

function get_book_author_relation_id($book_id, $author_id)
{
    $query = "SELECT * FROM book_author";
    $result = mysqli_query($_SESSION['link'], $query);

    if (!$result)
        die(mysqli_error($_SESSION['link'])); //если ошибка, останавливаем скрипт и выводим ошибку

    //Извлечение из БД
    $n = mysqli_num_rows($result); //кол-во строк в результате запроса
    $relations = array(); //создаем пустой массив

    for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $relations[] = $row;
    }
    foreach ($relations as $relation) {
        if ($relation['BOOK_ID'] == $book_id)
            if ($relation['AUTHOR_ID'] == $author_id) return $relation['RELATION_ID'];
    }

    return false;

}

function set_relations($book_id, $author_id)
{
    //request
    $sql = "INSERT INTO book_author (BOOK_ID, AUTHOR_ID) VALUES ('%s', '%s')";

    $query = sprintf($sql, mysqli_real_escape_string($_SESSION['link'], $book_id), mysqli_real_escape_string($_SESSION['link'], $author_id));

    $result = mysqli_query($_SESSION['link'], $query);

    if (!$result)
        die(mysqli_error($_SESSION['link']));
    return mysqli_affected_rows($_SESSION['link']);

    //return true;
}

function relation_delete($id)
{
    $id = (int)$id;

    //Request
    $query = sprintf("DELETE FROM book_author WHERE RELATION_ID='%d'", $id);
    $result = mysqli_query($_SESSION['link'], $query);

    if (!$result)
        die(mysqli_error($_SESSION['link']));

    return mysqli_affected_rows($_SESSION['link']);
}

function clean_book_author_relations()
{
    $query = "SELECT * FROM book_author, authors WHERE book_author.AUTHOR_ID = authors.AUTHOR_ID"; //выбираем все отношения книга-автор
    $result = mysqli_query($_SESSION['link'], $query);

    if (!$result)
        die(mysqli_error($_SESSION['link'])); //если ошибка, останавливаем скрипт и выводим ошибку

    //Извлечение из БД
    $n = mysqli_num_rows($result); //кол-во строк в результате запроса
    $book_authors = array(); //создаем пустой массив

    for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $book_authors[] = $row;
    }

    return $book_authors;

}


function author_exists($current_author)
{
    $query = "SELECT * FROM authors";
    $result = mysqli_query($_SESSION['link'], $query);

    if (!$result)
        die(mysqli_error($_SESSION['link'])); //если ошибка, останавливаем скрипт и выводим ошибку

    //Извлечение из БД
    $n = mysqli_num_rows($result); //кол-во строк в результате запроса
    $authors = array(); //создаем пустой массив

    for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $authors[] = $row;
    }
    foreach ($authors as $author) {
        if ($author['AUTHOR_NAME'] == trim($current_author)) return true;
    }

    return false;
}

function get_author_id($current_author)
{
    $query = "SELECT * FROM authors";
    $result = mysqli_query($_SESSION['link'], $query);

    if (!$result)
        die(mysqli_error($_SESSION['link'])); //если ошибка, останавливаем скрипт и выводим ошибку

    //Извлечение из БД
    $n = mysqli_num_rows($result); //кол-во строк в результате запроса
    $authors = array(); //создаем пустой массив

    for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $authors[] = $row;
    }
    foreach ($authors as $author) {
        if ($author['AUTHOR_NAME'] == trim($current_author)) return $author['AUTHOR_ID'];
    }

    return false;
}

function show_book_authors($id_book) //NO QUERY!! возвращает список авторов в одной строке, через запятую. Выбирает авторов из массива $book_authors
{
    $n = 0;
    $authors_str = '';
    foreach ($_SESSION['book_authors'] as $book_author) {
        if ($book_author['BOOK_ID'] == $id_book) {
            if ($n == 0) {
                $comma = '';
            } else {
                $comma = ', ';
            };
            $authors_str = $authors_str . $comma . $book_author['AUTHOR_NAME'];
            $n++;
        }
    }
    return $authors_str;
}

function current_book_authors($id_book)
{
    $current_book_authors = show_book_authors($id_book);
    if (empty($current_book_authors))
        $result = 'автор не указан';
    else $result = $current_book_authors;
    return $result;
}

function add_author($author) //возвращает ID нового автора
{
    //prepare
    $author = trim($author);

    //check
    if ($author == '') return false;
    //request
    $sql = "INSERT INTO authors (AUTHOR_NAME) VALUES ('%s')";

    $query = sprintf($sql, mysqli_real_escape_string($_SESSION['link'], $author));

    $result = mysqli_query($_SESSION['link'], $query);
    $new_author_id = mysqli_insert_id($_SESSION['link']);

    if (!$result)
    die(mysqli_error($_SESSION['link']));

    return $new_author_id;
}


function parse_authors($authors_string){
    $authors_array = array();
    return $authors_array;
}

function books_add($title, $author, $description)
{
    $_SESSION['link'] = db_connect();
    //prepare
    $title = trim($title);
    $author = trim($author);
    $description = trim($description);
    //$contributor = trim($contributor);

    //check
    //if ($title == '')
    //  return false;

    //request
    $t = "INSERT INTO books (BOOK_NAME, BOOK_DESCRIPTION) VALUES ('%s', '%s')";
//vd($_SESSION['link']);
    $query = sprintf($t, mysqli_real_escape_string($_SESSION['link'], $title), mysqli_real_escape_string($_SESSION['link'], $description));

    //echo $query;
    $result = mysqli_query($_SESSION['link'], $query);

    if (!$result)
        die(mysqli_error($_SESSION['link']));
    $new_book_id = mysqli_insert_id($_SESSION['link']);
    if ($author != '') {
        if (!author_exists($author))
            $current_author_id = add_author($author);
        else $current_author_id = get_author_id($author);//если  автор существует нужно вернуть его id и добавить новую запись в отношения книга-автор
            //vd($new_author_id);
            set_relations($new_book_id, $current_author_id);
    }
    return true;
}


function edit_book($id, $title, $author, $description)
{
    //prepare
    $_SESSION['link'] = db_connect();
    $link = $_SESSION['link'];
    $id = (int)$id;
    $title = trim($title);
    $description = trim($description);

    //check
    if ($title == '')
        return false;

    //request
    $sql = "UPDATE books SET BOOK_NAME='%s', BOOK_DESCRIPTION='%s' WHERE ID='%d'";

    $query = sprintf($sql, mysqli_real_escape_string($link, $title), mysqli_real_escape_string($link, $description), $id);

    $result = mysqli_query($link, $query);

    if (!$result)
        die(mysqli_error($link));

    if (!author_exists($author)) {
        add_author($author);
        set_relations($id, get_author_id($author));
    }
    return mysqli_affected_rows($link);
}


function books_delete($id)
{
    $id = (int)$id;
    $_SESSION['link'] = db_connect();

    //check
    if ($id == 0)
        return false;

    //Request
    $query = sprintf("DELETE FROM books WHERE id='%d'", $id);
    $result = mysqli_query($_SESSION['link'], $query);

    if (!$result)
        die(mysqli_error($_SESSION['link']));

    return mysqli_affected_rows($_SESSION['link']);
}


function intro($text, $l)
{
    if (mb_strlen($text) > 36)
        $result = mb_substr($text, 0, $l) . '...';
    else
        $result = mb_substr($text, 0, $l);
    return $result;
}

function vd($var)
{
    var_dump($var);
    die;
}

?>

