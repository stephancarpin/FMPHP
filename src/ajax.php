<?php
   if (isset($_GET))
       {
          require_once ('FileMaker.php');
          require_once ('DB_connection.php');

          $name       = $_GET['name'];
          $surname    = $_GET['surname'];
          $tasks_name = $_GET['tasks_name'];
          $progress   = $_GET['progress'];


          $fm     = new FileMaker();
          DB_connection::create_connection('localhost', 'Tasks','demo','demo',$fm);
          $rec    = $fm->createRecord('Tasks_Layout',  array( 'name'=> $name,
                                                              'surname'=> $surname,
                                                              'Task_name'=> $tasks_name,
                                                              'progress'=> $progress));
          $result = $rec->commit();

          echo 'Created Record';

       }
?>