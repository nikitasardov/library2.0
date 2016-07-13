<?php

/*
function get_all_data($link) //в разработке, не используется
{
    //запрос
    $query = "SELECT * FROM books, book_author, authors, genres WHERE books.ID = book_author.BOOK_ID AND book_author.BOOK_ID = authors.AUTHOR_ID AND books.GENRE_ID = genres.GENRE_ID ORDER BY ID DESC"; //выбираем все (*) из таблиц books, book_author, authors, genres сортируем (ORDER) по id  в обратном порядке (DESC)
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

function get_all_books() //запрос в базу, возвращает массив
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

function get_book_details($books_array, $id_book) //на входе массив книг и ID книги, на выходе массив с информацией о книге с этим ID
{
    foreach ($books_array as $current_book) {
        if ($current_book['ID'] == $id_book) {
            $book = $current_book;
            break;
        }
    }
    return $book;
}

function get_all_book_author_relations() //query!!получить все связи книга-автор. вызывается при загрузке "библиотеки", результаты хранятся в массиве $_SESSION['book_authors'] Не требуется напрягать базу, когда нужно получить список авторов для конкретной книги
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

function get_book_author_relation_id($book_id, $author_id) //получить ID связи по ID книги и автора
{
    if ($_SESSION['active'] == false) $_SESSION['book_authors'] = get_all_book_author_relations();
    foreach ($_SESSION['book_authors'] as $relation) {
        if (($relation['BOOK_ID'] == $book_id)&&($relation['AUTHOR_ID'] == $author_id)) return $relation['RELATION_ID'];
    }
    return false;
}

function relation_exists($book_id, $author_id) //проверка существования связи
{
    if ($_SESSION['active'] == false) $_SESSION['book_authors'] = get_all_book_author_relations();
    foreach ($_SESSION['book_authors'] as $relation) {
        if (($relation['BOOK_ID'] == $book_id) && ($relation['AUTHOR_ID'] == $author_id)) return true;
    }
    return false;
}

function set_relations($book_id, $author_id) //установить связь книга-автор
{
    //request
    $sql = "INSERT INTO book_author (BOOK_ID, AUTHOR_ID) VALUES ('%s', '%s')";
    $query = sprintf($sql, mysqli_real_escape_string($_SESSION['link'], $book_id), mysqli_real_escape_string($_SESSION['link'], $author_id));
    $result = mysqli_query($_SESSION['link'], $query);
    if (!$result) die(mysqli_error($_SESSION['link']));
    return mysqli_affected_rows($_SESSION['link']);
}

function relation_delete($id) //удалить связь по ID
{
    $id = (int)$id;
    //Request
    $query = sprintf("DELETE FROM book_author WHERE RELATION_ID='%d'", $id);
    $result = mysqli_query($_SESSION['link'], $query);
    if (!$result) die(mysqli_error($_SESSION['link']));
    return mysqli_affected_rows($_SESSION['link']);
}

function update_relations($book_id, $new_authors_list) //обновить связи книги с авторами
{
    $current_authors_array = parse_input($_SESSION['show_book_authors']);
    $new_authors_array = parse_input($new_authors_list);

    //удаление более не нужных связей
    foreach ($current_authors_array as $current_author) {
        $author_confirmed = false;
        foreach ($new_authors_array as $new_author) {
            if ($current_author == $new_author) {
                $author_confirmed = true;
                //  break;
            }
          //  echo 'author confirmed status: '.$author_confirmed.'<br>';
        }
        if (!$author_confirmed) {
            $relation_id = get_book_author_relation_id($book_id, get_author_id($current_author));
            echo 'relation ID: '.$relation_id.'<br>';
            relation_delete($relation_id);
            $_SESSION['active'] = false;
        }
    }
    //добавление новых авторов и создание новых связей
    foreach ($new_authors_array as $new_author) {
        //echo $new_author.' =? ';
        $new_author_confirmed = true;
        foreach ($current_authors_array as $current_author) {
            //echo $current_author.' ? <br>';
            if ($current_author == $new_author) {
                $new_author_confirmed = false;
                //echo $current_author.' not new<br>';
                //  break;
            }
        }
        if ($new_author_confirmed) {
            set_author($book_id, $new_author);
            $_SESSION['active'] = false;
        }
    }
    return true;

}

function author_exists($current_author) //проверка существования автора по имени. Возвращает true/false
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

function get_author_id($current_author) //получить ID автора по имени. Возвращает ID
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

function current_book_authors($id_book) //NO QUERY!! Выбирает авторов из массива $_SESSION['book_authors']. Возвращает список авторов в одной строке, через запятую.
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

function show_book_authors($id_book) //выводит список авторов книги. если не указаны авторы, выводит сообщние 'автор не указан';
{
    $current_book_authors = current_book_authors($id_book);
    if (empty($current_book_authors))
        $result = 'автор не указан';
    else $result = $current_book_authors;
    return $result;
}

function add_author($author) //на входе имя нового автора. вставляет в базу. возвращает ID нового автора
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
    if (!$result) die(mysqli_error($_SESSION['link']));
    return $new_author_id;
}

function parse_input($string) //на входе строка $string и разделители $delimiters. На выходе массив из элементов строки.
{
    $delimiters = ',/"|+=;:#@%`';
    $string = ',' . $string;
    //vd($string);
    $array = array();
    $n = 0;
    $array[$n] = trim(strtok($string, $delimiters));
    //echo $n.':'.$array[$n].'<br>';
    $swap = strtok($delimiters);
    while ($swap !== false) {
        $n++;
        $array[$n] = trim($swap);
        $swap = strtok($delimiters);
        //echo $n.':'.$array[$n].'<br>';
    }
    //die;
    return $array;
}

function add_book($title, $description) //добавить книгу $title с описанием $description. Возвращает ID
{
    $_SESSION['link'] = db_connect();
    //prepare
    $title = trim($title);
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
    return $new_book_id;
}

function set_authors($book_id, $author_string) //разбирает строку с авторами, перебирает получившийся массив, создает связь книга-автор.
{
    if ($author_string != '') {
        $authors_array = parse_input($author_string); //здесь строка с авторами будет разобрана в массив.
        //цикл, перебирающий массив с авторами:
        foreach ($authors_array as $single_author) {
            set_author($book_id, $single_author);
        }
    }
    return true;
}

function set_author($book_id, $single_author) //проверяет существование автора в базе, новых добавляет.
{
    if (!author_exists($single_author))
        $current_author_id = add_author($single_author);
    else $current_author_id = get_author_id($single_author);//если автор существует, вернуть id и добавить запись о новом отношении
    //vd($new_author_id);
    if (!relation_exists($book_id, $current_author_id))
        set_relations($book_id, $current_author_id);
    return true;
}

function edit_book($id, $title, $description) //редактирование книги. данные приходят из формы.
{
    //prepare
    $_SESSION['link'] = db_connect();
    $link = $_SESSION['link'];
    $id = (int)$id;
    $title = trim($title);
    $description = trim($description);
    //check
    if ($title == '') return false;

    //request
    $sql = "UPDATE books SET BOOK_NAME='%s', BOOK_DESCRIPTION='%s' WHERE ID='%d'";
    $query = sprintf($sql, mysqli_real_escape_string($link, $title), mysqli_real_escape_string($link, $description), $id);
    $result = mysqli_query($link, $query);
    if (!$result)
        die(mysqli_error($link));
    return mysqli_affected_rows($link);
}

function delete_book($id) //удалить книгу по ID
{
    $id = (int)$id;
    $_SESSION['link'] = db_connect();
    $_SESSION['show_book_authors'] = current_book_authors($id); //будет использовано при удалении связей
    //check
    if ($id == 0)
        return false;
    //Request
    $query = sprintf("DELETE FROM books WHERE id='%d'", $id);
    $result = mysqli_query($_SESSION['link'], $query);
    if (!$result) die(mysqli_error($_SESSION['link']));
    delete_book_author_relations($id);
    return mysqli_affected_rows($_SESSION['link']);
}

function delete_book_author_relations($book_id) //удаляет связи книга-автор по ID книги
{
    $authors_array = parse_input($_SESSION['show_book_authors']);

    //удаление более не нужных связей
    foreach ($authors_array as $current_author) {
            $relation_id = get_book_author_relation_id($book_id, get_author_id($current_author));
            //echo 'relation ID: '.$relation_id.'<br>';
            relation_delete($relation_id);
            $_SESSION['active'] = false;
    }
}

function intro($text, $l) //возвращает короткий текст ...
{
    if (mb_strlen($text) > 36)
        $result = mb_substr($text, 0, $l) . '...';
    else
        $result = mb_substr($text, 0, $l);
    return $result;
}

function vd($var) //вывести переменную и остановить скрипт
{
    var_dump($var);
    die;
}

?>

