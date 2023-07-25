<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(!@copy('F:\jk_media\img\uploads\attachmentsBackup\20191216125754_20394230_joiningReport.jpeg', 'F:\jk_media\img\uploads\profilePhoto\20191216125754_20394230_joiningReport.jpeg'))
{
    $errors= error_get_last();
    echo "COPY ERROR: ".$errors['type'];
    echo "<br />\n".$errors['message'];
} else {
  //do something
  echo "working 1";
}

die;

$dstfile = "F:\jk_media\img\uploads\123.txt";
mkdir(dirname($dstfile), 0777, true);

/* if(!copy("F:\jk_media\img\uploads\text.txt", "F:\jk_media\img\uploads\123.txt"))
{
	echo "hi";
}	 */

copy("F:\jk_media\img\uploads\text.txt", $dstfile);

?>  