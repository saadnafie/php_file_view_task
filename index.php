<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('classes/FileScan.php');
$cur_page = (isset($_SESSION['current_page']))?$_SESSION['current_page']:0 ;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Log File Viewer</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

  <style>
  		.table-bordered td, .table-bordered th{
  			border:none;
  		}
  </style>
</head>
<body>

<div class="card mb-3">
  	<div class="card-body">
  		Queen Tech Task

  		<form action="logout_action.php" method="GET" class="float-right">
		    <button class="btn btn-danger" type="submit" >Logout</button>
	 	</form>
	</div>
</div>
<div class="container">
	<h1>Log File Viewer</h1>
  	<hr>
  	 <form action="route.php" method="POST">
		  <div class="input-group mb-3">
		  <input type="text" class="form-control" placeholder="/path/to/file" name="file_path" required>
		  <div class="input-group-append">
		    <button class="btn btn-primary" type="submit" name="file_scan" value="openfile">View</button>
		  </div>
		</div>
	 </form>
	 <?php 
        if(!empty($_SESSION["file_path_err"])){
            echo '<div class="alert alert-danger">' . $_SESSION["file_path_err"] . '</div>';
            unset($_SESSION["file_path_err"]);
        }
        if(!empty($_SESSION["no_data"])){
            echo '<div class="alert alert-warning">' . $_SESSION["no_data"] . '</div>';
            unset($_SESSION["no_data"]);
        }     
    ?>

	 <table class="table table-bordered">
	    <tbody id="data_view">
	      <?php  
	      if(isset($_SESSION["data"]) && count($_SESSION["data"]) > 0){
	      	$data = $_SESSION["data"];
			    for($i = 0; $i < count($data['data']) ; $i++){
			      echo "<tr><td class='table-active'>".$data['lines'][$i]."</td><td>".$data['data'][$i]."</td></tr> ";
			  	}
				}
	      ?>
	    </tbody>
	 </table>

	 <ul class="pagination justify-content-center pagination-lg">
	 	<!--<button type="button" id="btn_next">Click Me</button>-->
		  <li class="page-item"><a class="page-link" href="#" onclick="paginationCall('first')" data-toggle="tooltip" title="Go to the beginning of the file">
		  	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-bar-left" viewBox="0 0 16 16">
			  <path fill-rule="evenodd" d="M11.854 3.646a.5.5 0 0 1 0 .708L8.207 8l3.647 3.646a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 0 1 .708 0zM4.5 1a.5.5 0 0 0-.5.5v13a.5.5 0 0 0 1 0v-13a.5.5 0 0 0-.5-.5z"/>
			</svg>
		  </a></li>
		  
		  <li class="page-item"><a class="page-link" href="#" onclick="paginationCall('previous')"  data-toggle="tooltip" title="Previous 10 lines">
		  	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-compact-left" viewBox="0 0 16 16">
			  <path fill-rule="evenodd" d="M9.224 1.553a.5.5 0 0 1 .223.67L6.56 8l2.888 5.776a.5.5 0 1 1-.894.448l-3-6a.5.5 0 0 1 0-.448l3-6a.5.5 0 0 1 .67-.223z"/>
			</svg>
		  </a></li>
		  
		  <li class="page-item"><a class="page-link" href="#" onclick="paginationCall('next')" data-toggle="tooltip" title="Next 10 lines">
		  	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-compact-right" viewBox="0 0 16 16">
			  <path fill-rule="evenodd" d="M6.776 1.553a.5.5 0 0 1 .671.223l3 6a.5.5 0 0 1 0 .448l-3 6a.5.5 0 1 1-.894-.448L9.44 8 6.553 2.224a.5.5 0 0 1 .223-.671z"/>
			</svg>
		  </a></li>

		  <li class="page-item"><a class="page-link" href="#" onclick="paginationCall('last')" data-toggle="tooltip" title="Go to the end of the file">
		  	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-bar-right" viewBox="0 0 16 16">
			  <path fill-rule="evenodd" d="M4.146 3.646a.5.5 0 0 0 0 .708L7.793 8l-3.647 3.646a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708 0zM11.5 1a.5.5 0 0 1 .5.5v13a.5.5 0 0 1-1 0v-13a.5.5 0 0 1 .5-.5z"/>
			</svg>
		  </a></li>
	</ul>

	<!--<span>Current Page: </span><b id="current_page_id">
		<?php
			
			echo $cur_page;
		?>
	</b> |
	<span>Pages Count: </span><b><?php

			echo (isset($_SESSION["file_pages"]))? $_SESSION["file_pages"] : 0;
		?></b>-->

</div>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<script>

function paginationCall(page_type) {


  $.ajax({
      type: 'POST',
      url: 'route.php',
      data: { file_data: page_type },
      success: function(data) {
   		//console.log(data);
        var dataResult = JSON.parse(data);
        	if(dataResult.error !== undefined){
        		alert(dataResult.error);
        	}else{
	          var dataList = "";
	          for(var i = 0,k=1; i< dataResult.data.length; i++, k++){
	          		dataList += "<tr><td class='table-active'>" + dataResult.lines[i] + "</td><td>" + dataResult.data[i] + "</td></tr>";
	          }
	          document.getElementById("data_view").innerHTML = dataList;
	          //document.getElementById("current_page_id").innerHTML = x;
        	}
      }
  });

}
</script>

</body>
</html>



