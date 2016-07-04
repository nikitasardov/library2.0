<!--php header('Content-type: text/html; charset=utf-8') ?-->
<!DOCTYPE html lang="ru">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="js/jquery-1.12.3.min.js"></script>
    <script type="text/javascript" src="js/functions.js"></script>
    <title>Библиотека.Каталог</title>
</head>
<body>
<div class="default__container">
    <div class="default__header">
        <h1 class="default__header--1">Библиотека</h1>
        <h2 class="default__header--2">Каталог</h2>
    </div>
    <div class="catalog__listContainer">
        <?php $num = 0;
        foreach ($books as $book): ?>

            <div class="catalog__card">
                <div class="catalog__cardHeader">
                    <h3 class="catalog__title"><?= ($num + 1) . '. "' . $book['BOOK_NAME'] ?>"</h3>
                    <h4 class="catalog__author"><?php echo current_book_authors($book['ID']);?></h4>
                </div>
                <a class="default__link--nodecoration canHide" href="<?php
                if (!empty($book['BOOK_DESCRIPTION']))
                    echo 'book.php?id=' . $book['ID'];
                else echo 'admin/index.php?action=edit&id=' . $book['ID'];
                if (isset($_GET['admin'])) echo '&admin';
                ?>">
                    <div class="book__description"><?php
                        if (empty($book['BOOK_DESCRIPTION']))
                            echo '<i>Нет описания. Вы можете добавить его, нажав кнопку "Редактировать"</i>';
                        else
                            echo intro(($book['BOOK_DESCRIPTION']), 50); ?>
                    </div>
                    <!--div class="default__bookInfo">Книга добавлена: <=intro($book['date'],16)?>
                    <php if (!empty($book['contributor'])) echo '<br>Добавил: '.$book['contributor'];?></div-->
                    <div class="default__button"><?php
                        if (!empty($book['BOOK_DESCRIPTION']))
                            echo 'Просмотреть';
                        else echo 'Редактировать'; ?></div>
                </a>


                </a>
            </div>
            <?php $num++; endforeach ?>
    </div>

    <div class="default__buttonContainer">
        <a class="default__link--nodecoration default__button default__button--recomended"
           href="admin/index.php?action=add">Добавить книгу</a>
        <a class="default__link--nodecoration default__button default__button--warning" href="admin">Редактор
            библиотеки</a>
    </div>

    <div class="default__bookInfo">Книг в базе: <?php echo $num; ?></div>
</div>
</body>
</html>
