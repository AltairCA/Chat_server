<?php



//$con=mysqli_connect("127.0.0.1","chat","chat","chat") or die("Error " . mysqli_error($link)); 



class MyDB extends SQLite3
   {
      function __construct()
      {
         $this->open('../build/msgs.db');
      }
}

$db = new MyDB();
   if(!$db){
      //echo $db->lastErrorMsg();
   } else {
      //echo "Opened database successfully\n";
}

$splitstring = ",,,,";
?>