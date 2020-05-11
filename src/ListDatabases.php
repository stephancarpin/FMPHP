<?php
class ListDatabase
{
   public static function list_databases($fm)
   {


      $databases = $fm->listDatabases();

      echo  '<ul class="list-group">';

      foreach ($databases as $database )
      {
         echo '<li class="list-group-item">';
         echo $database;
         echo '</li>';

      }
      echo '</ul>';
    }
}
?>
