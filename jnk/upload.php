<?php

if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {

     $File_Name          = strtolower($_FILES['userImage']['name']);
	$File_Ext           = substr($File_Name, strrpos($File_Name, '.')); //get file extention
	$Random_Number      = rand(0, 9999999999); //Random number to be added to name.
	$NewFileName 		= $Random_Number.$File_Ext; //new file name
    move_uploaded_file($_FILES['userImage']['tmp_name'],'uploads/'.$NewFileName);
    echo $NewFileName;

}  