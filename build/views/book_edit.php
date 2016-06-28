<!DOCTYPE html>
<html>
    <head>
	    <meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<style>
		</style>
		<link href="../css/styles.css" rel="stylesheet" type="text/css" />
        <title>Редактор библиотеки.Редактирование книги</title
    </head>
    <body>
        <div class="default__container">
            <div class="default__header">
                <h2 class="default__header--2 default--warning">Редактировать</h2>
            </div>
            <form method="post" action="index.php?action=edit&id=<?=$books['id']?>">
                <div class="input">
                    <input class="input__title" name="title" type="text" placeholder="Название книги" value="<?=$books['title']?>" required>
				    <input class="input__author" name="author" type="text" placeholder="Автор" value="<?=$books['author']?>" required>
                    <textarea class="input__description" name="description" placeholder="Фрагмент (по желанию)" autofocus required><?=$books['description']?></textarea>
                </div>
                <div class="default__bookInfo">Исправление: <?=$books['change_date']?><br>
                Добавление: <?=$books['date']?></div>
                <input name="change_date" type="hidden" value="<?=date('d-m-Y H:i:s')?>">
                <input name="editor_IP" type="hidden" value="<?=$_SERVER['REMOTE_ADDR']?>">
                <div class="default__buttonContainer">
				    <button class="default__button default__button--warning" type="submit">Сохранить</button>
                    <a class="default__link--nodecoration" href="<?php if(isset($_GET['admin'])) echo 'index.php'; 
                  else echo '../index.php';?>"><button type="button" class="default__button default__button--recomended">Отмена</button></a>
                </div>
			</form>
        </div>
    </body>
</html>