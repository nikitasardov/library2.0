<!DOCTYPE html lang="ru">
<html>
       
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link href="../css/styles.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="../js/jquery-1.12.3.min.js"></script>
        <script type="text/javascript" src="../js/functions.js"></script>
        <title>Редактор библиотеки</title>
    </head>
    <body>
        <div class="default__container">
            <div class="default__header">
                <h1 class="default__header--1">Библиотека</h1>
                <h2 class="default__header--2 default--warning">Редактор</h2>
            </div>
            <div class="catalog__listContainer">
                <?php $num=0; foreach($books as $book): ?>
                
                <div class="catalog__card">
                    <div class="catalog__cardHeader">
                        <h3 class="catalog__title">"<?=intro($book['title'], 36)?>"</h3>
                        <h4 class="catalog__author"><?php if (empty($book['author'])) echo 'автор не указан'; else echo $book['author'];?></h4>
                    </div>
                    <div class="canHide">
                        <div class="book__description"><?php 
                                if(empty($book['description'])) 
                                        echo '<i>Нет описания. Вы можете добавить его, нажав кнопку "Редактировать"</i></div>'; 
                                else 
                                        echo intro(($book['description']),50).'</div>';?>
                        <div class="default__bookInfo">Книга добавлена: <?=$book['date']?>
                        <br>Изменена: <?php if (empty($book['change_date'])) echo 'не редактировалась';
                                                    else echo $book['change_date'];?>
                        <br>Добавил: <?php if (!empty($book['contributor'])) echo $book['contributor'];
                                                    else echo 'Неизвестный';?>
                        </div>
                        <div class="default__line"></div>
                        <a class="default__link--nodecoration catalog__editButton" href="index.php?action=edit&id=<?=$book['id']?>&admin">Редактировать</a> | 
                        <a class="default__link--nodecoration catalog__deleteButton" href="index.php?action=delete&id=<?=$book['id']?>">Удалить</a>
                        <a class="default__link--nodecoration default__button" href="../book.php?id=<?=$book['id']?>&admin">Просмотреть</a>
                    </div>
                </div>
                <?php $num++; endforeach ?>
            </div>
            <div class="default__buttonContainer">
                <a class="default__link--nodecoration default__button default__button--recomended" href="index.php?action=add&admin">Добавить книгу</a>
                <a class="default__link--nodecoration default__button default__button--recomended" href="..">Каталог</a>
            </div>
            <div class="default__bookInfo">Книг в базе: <?php echo $num; ?></div>
        </div>
    </body>
</html> 