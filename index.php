<?php require_once ('FileMaker.php'); ?>
<?php require_once ('./src/ListDatabases.php'); ?>
<?php require_once ('./src/DB_connection.php'); ?>
<?php require_once ('./src/Utils.php'); ?>
<?php require_once ('./src/crud.php'); ?>

<?php  $fm = new FileMaker();//Require to use filemaker  PHP api?>
<html>

<head>
     <script src="https://code.jquery.com/jquery-3.5.0.min.js" crossorigin="anonymous"></script>
     <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="./src/app.js"></script>
<style>
p{
color:Blue;
}
</style>

</head>
<body>
	<div class="container-fluid text-center">
		 <h1>TASKS - PHP + Filemaker</h1>

		 <div class="container-fluid ">
		    <div class="container-fluid">
		        <p class="text-center">1. Example: Connecting to a server to get a list of databases </p>
                <?php ListDatabase::list_databases($fm);?>

		    </div>
          <div>

          <div class="container-fluid ">

             <p class="text-center">2.  Example: Connecting to a specific database on a server </p>
                 <?php DB_connection::create_connection('localhost', 'Tasks','demo','demo',$fm)?>

          </div>


          <div class="container-fluid ">

                       <p class="text-center">3.  GET Field NAMES</p>
                       <?php
                        //Get Fields on layout selected
                        $layout_object = $fm->getLayout('Tasks_Layout');
                        //Array of feilds
                        $field_objects = $layout_object->getFields();
                        echo "<table class='table table-dark'><tr>";
                        foreach($field_objects as $field_object)
                        {
                             $field_name = $field_object->getName();
                             echo "<td>". $field_name ."</tr>";
                         }
                         echo "</tr></table>";




                       echo '<p class="text-center">4.  Example: Find all command </p>';
                       //Find All record on layouts
                       $findCommand = $fm->newFindAllCommand('Tasks_Layout');
                       $result      = $findCommand->execute();
                       echo "<H2>Found Count:". $result->getFoundSetCount()."</H2>";



                       $Records_found  = $result->getRecords();

                       $page_content .= '<table  class="table table-dark" border="1">';
                       $page_content .= '<tr>';
                       $page_content .= '<th>&nbsp;</th>';

                        # loop through array of field objects to draw header
                        foreach($field_objects as $field_object) {

                            $field_name    = $field_object->getName();
                            $page_content .= '<th>'.$field_name.'</th>';

                        }
                        $page_content .= '</tr>';

                        # loop through record objects
                       foreach ($Records_found as $record_object) {
                                                                          $page_content .= '<tr>';
                                                                          $page_content .= '<td>' .$record_object->getRecordId().'</td>';

                                                                          # loop through array of field objects
                                                                          foreach($field_objects as $field_object) {

                                                                                 $field_name    = $field_object->getName();
                                                                                 $field_val     = $record_object->getField($field_name);
                                                                                 $field_val     = htmlspecialchars($field_val, ENT_QUOTES);
                                                                                 $field_val     = nl2br($field_val);
                                                                                 if ($field_name == 'progress')
                                                                                 {
                                                                                 $page_content .= '<td>
                                                                                                       <div class="progress" style="height: 10px;">
                                                                                                         <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: '. $field_val . '%;" aria-valuenow="'. $field_val .'" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                                       </div>
                                                                                                  </td>';
                                                                                 } else

                                                                                 {
                                                                                    $page_content .= '<td>'.$field_val.'</td>';
                                                                                 }

                                                                           }
                                                                         $page_content .= '</tr>';
                                                                     }
                                                                   $page_content .= '</table>'."\n";


                 echo $page_content;

                 if (FileMaker::isError($result)) {
                       echo "<p>Error: " . $result->getMessage() . "</p>";
                       exit;
                  }

           ?>



          <div class="container-fluid " style="padding:50px">
           <p class="text-center">5.  Example: Creating A Record via ajax </p>

           <div class="input-group input-group-sm mb-3">
             <div class="input-group-prepend">
               <span class="input-group-text" id="inputGroup-sizing-sm">Name</span>
             </div>
             <input  id='name'  type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
           </div>
           <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="inputGroup-sizing-sm">Surname</span>
                        </div>
                        <input  id='surname'  type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
            </div>
            <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text" id="inputGroup-sizing-sm">Tasks Name</span>
                                    </div>
                                    <input  id='tasks_name'  type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
             </div>
              <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                         <span class="input-group-text" id="inputGroup-sizing-sm">Progress</span>
                                    </div>
                                    <input  id='progress'  type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                          </div>
            <div class="container-fluid " >

              <button id='create_o' type='button' class='btn btn-dark' onclick='create_record_ajax()'  >Create</button>

              </div>
            </div>

         </div>
</body>

</html>

