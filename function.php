<?php

/* 
 * 
 */

class Application{
    
    private static function dbConnect($sql = ""){
        
            //Подключение к БД
            $db = new PDO('mysql:host='.SETTINGS::HOST_DB.';dbname='.SETTINGS::DB.'', SETTINGS::USER_DB, SETTINGS::PASS_DB);
            
            // Задает кодировку
            $db->exec("set names utf8");
            
            //отправляет запрос
            $query = $db->query($sql);
              
            //завершает сеанс
            $dbh = null;
            
            return $query;
        
    }
    
    public static function dbQuery($sql = ""){
        
        
        //Если есть SQL
        if ( !empty($sql) ){
            
            //делает соединение с сервером
            $query = self::dbConnect($sql);
            
            //получает ассоциативный массив
            $query->setFetchMode(PDO::FETCH_ASSOC);
            
            //возвращает массив
            return $query;
            
        } else {
            return false;
        }
        
        
    }
    
    public static function returnJSON($url = ""){
        
        if ( !empty($url) ){
            //URL - bitrix24 API/ return JSON

            $result_url = json_decode(file_get_contents($url)); //parser JSON

            return $result_url;
            
        } else return false;
        
        
    }
}