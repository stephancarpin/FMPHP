<?php
class Db_connection
{
 public static function create_connection ($hostname,$db_name,$username,$password,$fm)
  {

    $fm->setProperty('database', $db_name);
   // $fm->setProperty('hostspec', $hostname);
    $fm->setProperty('username', $username);
    $fm->setProperty('password', $password);


  }
}

?>