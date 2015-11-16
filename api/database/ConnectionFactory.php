<?php
class ConnectionFactory{
    
    
    
    public function getDB(){
        
    }
    
    private static function getConnection(){
         $dbhost = getenv('IP');
         $dbuser = getenv('C9_USER');
         $dbpass = '';
         $dbname = 'C9';
         
         $connection = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbpass,$dbuser);
         return $connection;
         
        
    }
}


?>
