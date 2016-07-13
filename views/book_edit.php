<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <style>
    </style>
    <link href="../css/styles.css" rel="stylesheet" type="text/css"/>
    <title>Редактор библиотеки.Редактирование книги</title>
</head>
<body>
<div class="default__container">
    <div class="default__header">
        <h1 class="default__header--1">Библиотека 2.0</h1>
    </div>
    <div class="default__header">
        <h2 class="default__header--2 default--warning">Редактировать книгу</h2>
    </div>
    <form method="post" action="index.php?action=edit&id=<?php echo $book['ID']; ?>">
        <div class="input">
            <input class="input__title" name="title" type="text" placeholder="Название книги" value="<?php
            echo $book['BOOK_NAME']; ?>" required>
            <div class="book__description" style="background-color: rgba(0, 0, 0, .4); padding: 5px;border-radius: 5px; margin-bottom: 5px;">Отредактируйте список авторов. <br>Используйте символы-разделители: , / &quot; | + = ; : # @ % ` ~</div>
            <input class="input__author" name="author" type="text" placeholder="Авторы (используйте символы-разделители: , / &quot; | + = ; : # @ % ` ~)" value="<?php
            $_SESSION['show_book_authors'] = current_book_authors($book['ID']); //сохраняем авторов до редактирования, потом сравним и узнаем, есть ли изменения
            echo $_SESSION['show_book_authors'];?>" required>
            <textarea class="input__description" name="description" placeholder="Фрагмент (по желанию)"
                              autofocus required><?php echo $book['BOOK_DESCRIPTION']; ?></textarea>
        </div>
        <!--div class="default__bookInfo">Исправление: <=$books['change_date']?><br>
        Добавление: <=$books['date']?></div>
        <input name="change_date" type="hidden" value="<=date('d-m-Y H:i:s')?>">
        <input name="editor_IP" type="hidden" value="<=$_SERVER['REMOTE_ADDR']?>"-->
        <div class="default__buttonContainer">
            <button class="default__button default__button--warning" type="submit">Сохранить</button>
            <a class="default__link--nodecoration" href="<?php
            if (isset($_GET['admin']))
                echo 'index.php';
            else echo '../index.php';
            ?>">
                <button type="button" class="default__button default__button--recomended">Отмена</button>
            </a>
        </div>
    </form>
</div>
</body>
</html>
