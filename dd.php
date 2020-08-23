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

error_reporting(0);

 if (isset($_POST['submit_download']))
      {

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

       $code = $_POST['code'];
	   
   
        $sql= " SELECT name, type, size, data FROM fud_uploads WHERE code ='$code' and flag < '1'";
        $result = $conn->query($sql);
 
        if($result) 
         {
                $row = $result->fetch_assoc();
				
				$data = $row['data'];
				
				$file = substr($data, (strpos($data, '=') ?: -1) + 1);
             
			    header("Content-Type: ". $row['type']);
                header("Content-Length: ". $row['size']);
                header('Content-Disposition:attachment;filename="' .$row['name'] .'"');  
  			
               echo $file;
			 

			$sql2= "DELETE FROM fud_uploads WHERE code ='$code'";
            $result2 = $conn->query($sql2);
  
             if ($result2 == TRUE)
			 {
            header('Location:error'); 
			 }
            
			
			} // end of result donwload
			
			
			
            else 
            {
              echo 'Error: File not find.';
            }
			
			

				
  
	} // end else of connect


$conn->close();

}// end if isset
 	  
	  
?>