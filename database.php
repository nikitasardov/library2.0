<?php
    define('LOCAL_MYSQL_SERVER', 'localhost');
    define('LOCAL_MYSQL_USER', 'root');
    define('LOCAL_MYSQL_PASSWORD', 'root');
    define('LOCAL_MYSQL_DB', 'library20');

    define('HOSTING_MYSQL_SERVER', 'localhost');
    define('HOSTING_MYSQL_USER', 'u666554409_root');
    define('HOSTING_MYSQL_PASSWORD', 'WmroS1X7DU');
    define('HOSTING_MYSQL_DB', 'u666554409_libr2');

function db_connect() {
    $link = mysqli_connect(HOSTING_MYSQL_SERVER, HOSTING_MYSQL_USER, HOSTING_MYSQL_PASSWORD, HOSTING_MYSQL_DB);
    if(!$link) $link = mysqli_connect(LOCAL_MYSQL_SERVER, LOCAL_MYSQL_USER, LOCAL_MYSQL_PASSWORD, LOCAL_MYSQL_DB);
    else if(!$link) die("Error: ".mysqli_error($link));
    if(!mysqli_set_charset($link, "utf8")){
        printf("Error: ".mysqli_error($link));
    }

    return $link;
}

?>
