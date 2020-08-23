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
	 
         <h1 align="center"> 
		   <a href="/" style="text-decoration:none; color:white"> FUD </a> 
		  </h1>

          <img src='img/bg1.gif' height="300px" width="100%"> 
        
        <form  action="" method="POST" enctype="multipart/form-data">

		  
          <div class="form-group">
            <label for="exampleFormControlSelect1"> <font color="white"> Select Server </font> </label>
            <select class="form-control" id="exampleFormControlSelect1" name="platform" required="required">
              <option> Avenger Server: &nbsp; AV-0|1 </option>
              <option> Butterfly Server: &nbsp; BU-1|0 </option>
			  <option> Commander Server: &nbsp; CM-0|0 </option>
              <option> Dragon Server: &nbsp; DR-1|1 </option>
            </select>
          </div>
		  
          <hr>
          <div class="form-group mt-3">
            <label class="mr-2"> <font color="white"> Upload your File: </font> </label>
           <font color="white"> <input type="file" name="upload_file"> </font>
          </div>
		  
          <hr>
		  
		  <button type="reset" class="btn btn-danger btn-block">  Cancel <i class="fa fa-trash"></i> </button>
          <button type="submit" class="btn btn-success btn-block" name="submit_file"> 
		    Upload File <i class="fa fa-upload"></i> 
	       </button>
		  
        </form>
    </div> 
    


</body>
</html>



<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

  if (isset($_POST['submit_file']))
      {

  define('KB', 1024);
  define('MB', 1048576);
  define('GB', 1073741824);
  define('TB', 1099511627776);

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

        $name = $conn->real_escape_string($_FILES['upload_file']['name']);
        $type = $conn->real_escape_string($_FILES['upload_file']['type']);
        $size = $_FILES['upload_file']['size'];
        $data = $conn->real_escape_string(file_get_contents($_FILES ['upload_file']['tmp_name']));
       

 if (empty(file_get_contents($_FILES ['upload_file']['tmp_name'])))
      {
       echo '<script type="text/javascript">alert("Error. your file is empty or than bigest to 100mb ");
            </script>';
       echo ("<script>location.href='/'</script>"); 
                }

                 

     else
        {  
	
		 $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
         $len = 16;
         $len = substr(str_shuffle("ABCDEF0123456789"),0, $len);
 
         $code = $len;
 
         $link = $url."d.php?d=".$len;
		
        //encrypt
		//$str = bin2hex(openssl_random_pseudo_bytes(10)); // 20 chars
		$str = "CCC8333I";
		$key = "1 0 obj=";
        $file = $key .$data;
		

		
            $sql="INSERT INTO fud_uploads (name,type,size,data,created,link,code,flag) 
                    VALUES('$name','$type','$size','$file',NOW(),'$link','$code','0')";
            $result=$conn->query($sql);

                if ($result == TRUE)
				  {
				  echo "<div id='outer'>  
                   <div id='inner'> 
				         <font color='white' size='4'> This link for download </font>
  						 
						   <br> 
						 
						 <input type='text' value='$link' id='myInput' size='50'>
                           <button onclick='myFunction()'> Copy link </button>
 
                           <script>
                            function myFunction() {
                            var copyText = document.getElementById('myInput');
                            copyText.select();
                            copyText.setSelectionRange(0, 99999)
                            document.execCommand('copy');
                              }
                           </script>

						 </div>
					    </div>";	
                       
						
				    }
                      
              } // end else empty or biggest

            } // end else connect
                      

 $conn->close();

}// end if isset


?>