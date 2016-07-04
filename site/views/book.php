<!DOCTYPE html><!--php if (mb_strlen($book['BOOK_DESCRIPTION']) > 600) echo 'lang="ru"';?-->
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <style></style>
    <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    <title>Библиотека.Описание книга</title>
</head>
<body>
<div class="default__container">
    <div class="default__header">
        <h1 class="default__header--1<?php if (isset($_GET['admin'])) echo ' default--warning'; ?>">Описание</h1>
    </div>
    <div class="book__card">
        <?php $book = show_book_details($books, $_GET['id']); ?>
        <h2 class="book__title">"<?php echo $book['BOOK_NAME']; ?>"</h2>
        <h3 class="book__author"><?php echo current_book_authors($book['ID']);?></h3>
        <div class="default__line"></div>
        <div class="book__description<?php if (mb_strlen($book['BOOK_DESCRIPTION']) > 600) echo '--read' ?>">

            <?php if (empty($book['BOOK_DESCRIPTION']))
                echo '<i>Нет описания. Вы можете добавить его, нажав кнопку "Редактировать"</i>';
            else
                echo $book['description']; ?>
        </div>
        <div class="default__line"></div>
        <div class="default__bookInfo">
            <!--php if (isset($_GET['admin'])) {
                echo 'Исправлена: ';
                if (empty($book['change_date'])) echo 'не редактировалась';
                else echo $book['change_date'];
                echo '<br>Добавлена: ' . $book['date'] . '<br>';
            } else
                echo 'Добавлена: ' . intro($book['date'], 16) . '<br>';
            if (!empty($book['contributor'])) echo 'Добавил: ' . $book['contributor']; ?-->
        </div>
    </div>
    <div class="default__buttonContainer">

        <a class="default__link--nodecoration default__button default__button--<?php
        if ((!empty($book['description'])) && (isset($_GET['admin']))) echo 'warning'; else echo 'recomended'; ?>"
           href="admin/index.php?action=<?php
           if ((!isset($_GET['admin'])) && (!empty($book['description']))) echo 'add'; else echo 'edit'; ?>&id=<?= $book['id']; ?><?php if (isset($_GET['admin'])) echo '&admin'; ?>"><?php
            if ((!isset($_GET['admin'])) && (!empty($book['description']))) echo 'Добавить новую'; else echo 'Редактировать'; ?>
        </a>

        <a class="default__link--nodecoration default__button default__button--recomended"
           href="<?php if (isset($_GET['admin'])) echo 'admin/'; ?>index.php"><?php if (!isset($_GET['admin'])) echo 'Каталог'; else echo 'Редактор библиотеки'; ?>
        </a>
    </div>
</div>
</body>
</html>