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

function get_all_books($link){
    //запрос
    $query = "SELECT * FROM books, ganres WHERE books.GANRE_ID = ganres.GANRE_ID ORDER BY ID DESC"; //выбираем все (*) из таблицы books, сортируем (ORDER) по id  в обратном порядке (DESC)
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

function get_all_book_authors($link) //query!!получить все связи книга-автор. вызывается при загрузке "библиотеки", результаты хранятся в массиве $book_authors Не требуется напрягать базу, когда нужно получить список авторов для конкретной книги
{
    $query = "SELECT * FROM book_author, authors WHERE book_author.AUTHOR_ID = authors.AUTHOR_ID ORDER BY BOOK_ID DESC"; //выбираем все отношения книга-автор
    $result = mysqli_query($link, $query);

    if (!$result)
        die(mysqli_error($link)); //если ошибка, останавливаем скрипт и выводим ошибку

    //Извлечение из БД
    $n = mysqli_num_rows($result); //кол-во строк в результате запроса
    $book_authors = array(); //создаем пустой массив

    for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $book_authors[] = $row;
    }

    return $book_authors;

}

function show_book_authors($book_authors, $id_book) //NO QUERY!! возвращает список авторов в одной строке, через запятую. Выбирает авторов из массива $book_authors
{
    $n = 0;
    foreach ($book_authors as $book_author) {
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

/*
function get_book_authors($link, $id_book) //query!! старый вариант функции. обращение к базе при выводе каждой книги в списке. Функция больше не используется.
{
    //запрос
    $query = "SELECT * FROM book_author, authors WHERE book_author.BOOK_ID = " . $id_book . " AND book_author.AUTHOR_ID = authors.AUTHOR_ID ORDER BY BOOK_ID DESC"; //выбираем все (*) из таблиц books_author и author
    $result = mysqli_query($link, $query);

    if (!$result)
        die(mysqli_error($link)); //если ошибка, останавливаем скрипт и выводим ошибку

    //Извлечение из БД
    $n = mysqli_num_rows($result); //кол-во строк в результате запроса
    $authors = array(); //создаем пустой массив

    for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $authors[] = $row;
    }
    $n = 0;
    foreach ($authors as $author) {
        if ($n == 0) {
            $comma = '';
        } else {
            $comma = ', ';
        };
        $authors_str = $authors_str . $comma . $author['AUTHOR_NAME'];
        $n++;
    }
    return $authors_str;
}
*/

/*
function get_book($link, $id_book)
{
    //запрос
    $query = sprintf("SELECT * FROM books WHERE id=%d", (int)$id_book);
    $result = mysqli_query($link, $query);

    if (!$result)
        die(mysqli_error($link));

    $book = mysqli_fetch_assoc($result);

    return $book;
}
*/
/*

  function books_add($link, $title, $author, $description, $date, $contributor, $contributor_IP){
  //prepare
  $title = trim($title);
  $author = trim($author);
  $description = trim($description);
  $contributor = trim($contributor);

//    if (empty($contributor)) $contributor = 'Доброжелатель, опознанный по IP';

  //check
  if ($title == '')
      return false;

  //request
  $t = "INSERT INTO books (title, author, description, date, change_date, contributor, contributor_IP) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')";

  $query =  sprintf($t, mysqli_real_escape_string($link, $title), mysqli_real_escape_string($link, $author), mysqli_real_escape_string($link, $description), mysqli_real_escape_string($link, $date), mysqli_real_escape_string($link, 'не редактировалась'), mysqli_real_escape_string($link, $contributor), mysqli_real_escape_string($link, $contributor_IP));

  //    echo $query;
      $result = mysqli_query($link, $query);

      if (!$result)
          die(mysqli_error($link));

      return true;
  }
*/

/*
function edit_book($link, $id, $title, $author, $description)
{
    //prepare
    $id = (int)$id;
    $title = trim($title);
    $description = trim($description);

    //check
    if ($title == '')
        return false;

    //request
    $sql = "UPDATE books SET BOOK_NAME='%s', description='%s' WHERE id='%d'";

    $query = sprintf($sql, mysqli_real_escape_string($link, $title), mysqli_real_escape_string($link, $description);

    $result = mysqli_query($link, $query);

    if (!$result)
        die(mysqli_error($link));
    //set_relations($id, set_authors(trim($author)));
    return mysqli_affected_rows($link);
}
*/


function set_authors($authors)
{
    /*
    //prepare
    $id = (int)$id;
    $title = trim($title);
    $description  = trim($description);
  
    //check
    if ($title == '')
        return false;
  
    //request
    $sql = "UPDATE books SET BOOK_NAME='%s', description='%s' WHERE id='%d'";
  
    $query = sprintf($sql, mysqli_real_escape_string($link, $title), mysqli_real_escape_string($link, $author), mysqli_real_escape_string($link, $description);
  
    $result = mysqli_query($link, $query);
  
    if (!$result)
        die(mysqli_error($link));
    set_relations($id, set_authors(trim($author)));
    return mysqli_affected_rows($link);
    */
    //return $authors_arr;
}



function set_relations($authors)
{
    /*
    //prepare
    $id = (int)$id;
    $title = trim($title);
    $description  = trim($description);
  
    //check
    if ($title == '')
        return false;
  
    //request
    $sql = "UPDATE books SET BOOK_NAME='%s', description='%s' WHERE id='%d'";
  
    $query = sprintf($sql, mysqli_real_escape_string($link, $title), mysqli_real_escape_string($link, $author), mysqli_real_escape_string($link, $description);
  
    $result = mysqli_query($link, $query);
  
    if (!$result)
        die(mysqli_error($link));
    set_relations($id, set_authors(trim($author)));
    return mysqli_affected_rows($link);
    */
    //return true;
}


/*
  function books_delete($link, $id){
      $id = (int)$id;

      //check
      //if ($id == 0)
        //  return false;

      //Request
      $query = sprintf("DELETE FROM books WHERE id='%d'", $id);
      $result = mysqli_query($link, $query);

      if (!$result)
          die(mysqli_error($link));

      return mysqli_affected_rows($link);
  }
*/

function intro($text, $l)
{
    if (mb_strlen($text) > 36)
        $result = mb_substr($text, 0, $l) . '...';
    else
        $result = mb_substr($text, 0, $l);
    return $result;
}


function vd($var){
    var_dump($var);
    die;
}

?>

