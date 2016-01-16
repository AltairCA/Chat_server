<?php
// In PHP versions earlier than 4.1.0, $HTTP_POST_FILES should be used instead
// of $_FILES.
set_time_limit(3600);

$uploaddir = "upload/";
$nu = rand(1,10000000);
$exts = explode(".", $_FILES['userfile']['name']);
$ext = $exts[count($exts)-1];
//$ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
while(file_exists ($uploaddir.$nu.".".$ext )){
	$nu = rand(1,10000000);
}
//$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
$uploadfile = $uploaddir.$nu.".".$ext;

//echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "image_process:".$nu.".".$ext;
} else {
    echo "fail";
}

//echo 'Here is some more debugging info:';
//print_r($_FILES);

//print "</pre>";

?>