<?php

/*
 * Copyright (c) 2020 Barchampas Gerasimos
 * Fud is a program upload and download files for one-time.
 *
 * fud is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 *
 * fud is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 */

?>

<html>
<head>


 <title> FUD </title>

 <link rel="icon" href="img/icon.png">


<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<style>

body
{
background-image: url("img/bg0.gif"); 
background-size: 100% 100%;
background-position: left; 
background-repeat: no-repeat; 
background-color: ;
}

h1
{
font-size: 25px;
margin-top: -40px;
}


img
{
border-radius: 40%;
}

#outer {
  width: 100%;
  text-align: center;
}

#inner {
  display: inline-block;
}

</style>



</head>


<body>

<audio autoplay loop>
<source src="media/song.mp3" type="audio/mpeg">
</audio>


     <div class="col-md-6 offset-md-3 mt-5">
                <h1 align="center"> <font color="white"> FUD </font> </h1>

          <img src='img/bg1.gif' height="300px" width="100%"> 
        
        <form  action="dd.php" method="POST" enctype="multipart/form-data">

          <?php
		  
		  error_reporting(0);
		  
		      require('class_cn.php');

               $obj = new in;
 
               $host=$obj->connect[0];
               $user=$obj->connect[1];
               $pass=$obj->connect[2];
               $db=$obj->connect[3];

               $conn = new mysqli($host,$user,$pass,$db);
			   
			     if ($conn->connect_error)
                  {
                 die ("Connect error " .$conn->connect_error);
                 }
 
 
            else
		      {
			   
		      $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

              $needle = $url;
              $code = substr($needle, (strpos($needle, '=') ?: -1) + 1);
 
              $sql= " SELECT name,code FROM fud_uploads WHERE code ='$code'";
              $result = $conn->query($sql);
			  
			  
		     if($result) 
             {
				 
		     while ($row = $result->fetch_assoc())
		        {
				 $file_name = $row['name'];	
				 $code = $row['code'];
		         }
		  
		  echo"
          <div class='form-group'>
            <label for='exampleFormControlSelect1'> <font color='white'> File Name </font> </label>
            <select class='form-control' id='exampleFormControlSelect1' name='file_name'>
              <option> $file_name </option>
            </select>
          </div>";
		  
		  
		   echo"
          <div class='form-group'>
            <select class='form-control' id='exampleFormControlSelect1' name='code' hidden>
              <option> $code </option>
            </select>
          </div>";
		    
			 } // end of if result
			 
	    } // end of if else 
		  
		  ?>
	
          <hr>
		  
          <button type="submit" class="btn btn-success btn-block" name="submit_download"> 
		    Download File <i class="fa fa-download"></i> 
	       </button>
		  
        </form>
    </div> 
    


</body>
</html>