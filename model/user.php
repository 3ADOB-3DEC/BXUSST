<?php


class USERS{
    
    public static function generalUser(){
        
        if ($pareser_id = Application::returnJSON( "https://".SETTINGS::URL_BX24."/rest/12/".SETTINGS::KEY."/user.get/" )){
            
            $result_url = $pareser_id->result;
                       
            Application::dbQuery("DELETE FROM `worktime_user` WHERE `id`"); //Удалит всё из таблицы
            Application::dbQuery("ALTER TABLE `worktime_user` AUTO_INCREMENT = 1");//Поменяет счёт на 1

            //Проходит по всем объектам JSON 
            foreach ( $result_url as $key=>$data ){

                //Формирует SQL
                $SQL = "INSERT INTO `worktime_user` (`id`, `USER_ID`, `USER_ACTIVE`, `USER_NAME`, `USER_LAST_NAME`, `USER_EMAIL`, `USER_PERSONAL_PHOTO`, `USER_WORK_POSITION`, `USER_PERSONAL_BIRTHDAY`) VALUES ("
                    . "NULL, "
                    . "'$data->ID', "
                    . "'$data->ACTIVE', "
                    . "'$data->NAME', "
                    . "'$data->LAST_NAME', "
                    . "'$data->EMAIL', "
                    . "'$data->PERSONAL_PHOTO', "
                    . "'$data->WORK_POSITION', "
                    . "'$data->PERSONAL_BIRTHDAY'"
                    . ")";

                //Отправляет SQL на сервер
                Application::dbQuery($SQL);

            }
        
        }
    }
    
    public static function getUsers($select = "*"){
        
        $users_active = Application::dbQuery("SELECT $select FROM `worktime_user` WHERE `USER_ACTIVE` = 1");
        
        return $users_active;
        
        
    }
    
}