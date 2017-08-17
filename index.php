<?php
/*
    * Главный файл запуска скрипта
 */
$start = microtime(true); //Старт скрипта. Фиксирование времени работы.


/*
 * Подключение всех компонентов
 */
include_once 'function.php';
include_once 'model/user.php';
include_once 'settings.php';


?>


<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>test</title>
    </head>
    <body>
<?php
    /*Генерируем пользовотелей в БД*/
    USERS::generalUser();
    
    //Получаем все id-пользовотелей
    $users_id = USERS::getUsers("`USER_ID`");
    
    //Обработка всех пользователей
    while ($row = $users_id->fetch()){
        
        //Если можно получить данные от пользователя
        if ($pareser_id = Application::returnJSON("https://".SETTINGS::URL_BX24."/rest/12/".SETTINGS::KEY."/timeman.status/?user_id=".$row["USER_ID"])){
            //получаем объект данных
            $data = $pareser_id->result;
            
            //Формирует SQL
            $SQL = "INSERT INTO `worktime_data` (`id`, `day`, `time`, `user`, `STATUS`, `TIME_START`, `TIME_FINISH`, `DURATION`, `TIME_LEAKS`, `ACTIVE`, `IP_OPEN`, `IP_CLOSE`, `LAT_OPEN`, `LON_OPEN`, `LAT_CLOSE`, `LON_CLOSE`, `TZ_OFFSET`) VALUES ("
                    . "'NULL', "
                    . "CURRENT_DATE(), "
                    . "CURRENT_TIME(), "
                    . "'".$row["USER_ID"]."', "
                    . "'$data->STATUS', "
                    . "'$data->TIME_START', "
                    . "'$data->TIME_FINISH', "
                    . "'$data->DURATION', "
                    . "'$data->TIME_LEAKS', "
                    . "'$data->ACTIVE', "
                    . "'$data->IP_OPEN', "
                    . "'$data->IP_CLOSE', "
                    . "'$data->LAT_OPEN', "
                    . "'$data->LON_OPEN', "
                    . "'$data->LAT_CLOSE', "
                    . "'$data->LON_CLOSE', "
                    . "'$data->TZ_OFFSET')";

            //Отправляет SQL на сервер
            Application::dbQuery($SQL);

            
           
        }
    }
    
    echo 'Время выполнения скрипта: '.(microtime(true) - $start).' сек.';
    echo '<br/>Дата обновления скрипта: '.date("d.m.y");
    echo '<br/>Время обновления скрипта: '.date("H:i:s");

?>
    </body>
</html>