<?php
class DB{
    private static $conn=null;
    public static function getConnection(){
        if (self::$conn==null){
            self::$conn=new PDO('mysql:host=' . 'bd-votos' . ';port=3306;dbname=' . 'votacion', 'root','root');
        }
    return self::$conn;
    }
}

?>