<?php

    function books_all($link){
        //запрос
        $query = "SELECT * FROM books ORDER BY id DESC"; //выбираем все (*) из таблицы books, сортируем (ORDER) по id  в обратном порядке (DESC)
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





    function books_get($link, $id_book)
    {
        //запрос
        $query = sprintf("SELECT *  FROM books WHERE id=%d",(int)$id_book);
        $result = mysqli_query($link, $query);
        
        if (!$result)
            die(mysqli_error($link));
        
        $book = mysqli_fetch_assoc($result);
            
        return $book;
    }



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

    function books_edit($link, $id, $title, $author, $description, $change_date, $editor_IP){
        //prepare
        $id = (int)$id;
        $title = trim($title);
        $author = trim($author);
        $description  = trim($description);
        
        
        //check
        if ($title == '')
            return false;
        
        //request
        $sql = "UPDATE books SET title='%s', author='%s', description='%s', change_date='%s', editor_IP='%s' WHERE id='%d'";
        
        $query = sprintf($sql, mysqli_real_escape_string($link, $title), mysqli_real_escape_string($link, $author), mysqli_real_escape_string($link, $description), mysqli_real_escape_string($link, $change_date), mysqli_real_escape_string($link, $editor_IP), $id);
        
        $result = mysqli_query($link, $query);
        
        if (!$result) 
            die(mysqli_error($link));
        
        return mysqli_affected_rows($link);
    }

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

function intro($text, $l)
{
    if (mb_strlen($text) > 36)
        $result = mb_substr($text, 0 , $l).'...'; 
    else
    $result = mb_substr($text, 0 , $l);
    return $result;
}
?>