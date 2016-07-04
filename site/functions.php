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

function get_all_book_authors() //query!!получить все связи книга-автор. вызывается при загрузке "библиотеки", результаты хранятся в массиве $book_authors Не требуется напрягать базу, когда нужно получить список авторов для конкретной книги
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

function show_book_authors($id_book) //NO QUERY!! возвращает список авторов в одной строке, через запятую. Выбирает авторов из массива $book_authors
{
    $n = 0;
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

function books_add($title, $description)
{
    //prepare
    $title = trim($title);
    //$author = trim($author);
    $description = trim($description);
    //$contributor = trim($contributor);
    $link = $_SESSION['link'];

//    if (empty($contributor)) $contributor = 'Доброжелатель, опознанный по IP';

    //check
    if ($title == '')
        return false;

    //request
    $t = "INSERT INTO books (BOOK_NAME, GANRE_ID, SCHOOL_RECOMENDS, BOOK_DESCRIPTION) VALUES ('%s', '%s', '%s', '%s')";
vd($_SESSION['link']);
    $query = sprintf($t, mysqli_real_escape_string($link, $title), mysqli_real_escape_string($link, '0'), mysqli_real_escape_string($link, $title), mysqli_real_escape_string($link, $description));

    //    echo $query;
    $result = mysqli_query($link, $query);

    if (!$result) vd('что-то не так');
        //die(mysqli_error($link));

    return true;
}

function edit_book($id, $title, $description)
{
    //prepare
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
    //set_relations($id, set_authors(trim($author)));
    return mysqli_affected_rows($link);
}



function current_book_authors($id_book)
{
    $current_book_authors = show_book_authors($id_book);
    if (empty($current_book_authors))
        $result = 'автор не указан';
    else $result = $current_book_authors;
    return $result;
}

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


function vd($var)
{
    var_dump($var);
    die;
}

?>

