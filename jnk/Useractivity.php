<?php

/**
 * Log User activity
 *
 * @author Chandrakant Borse & Deeptaroop Maitra
 */

/** 1-5002229301
 * Class ASRole
 * Description: Class for manipulating with user roles.
 */
class Useractivity {

  // public $ip_address = $_POST['ip'];
    /**
     * Get user id and tyoe of activity
     * @param $name Role name
     * @return Role id if role with provided role name exist, null otherwise.
     */
    public function saveActivity($con,$data) {
	//include 'privateip.php';	
	$ip_address_private = $_POST['ips'];
 	$user_agent = $_SERVER['HTTP_USER_AGENT'];
		 if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			//ip from share internet
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			//ip pass from proxy
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			$ip_address = $_SERVER['REMOTE_ADDR'];
		} 
		
	$saveActivityQuery="INSERT INTO user_activity (description,user_id,role,ip_address,user_agent,private_ip,city,region,loc) VALUES (?,?,?,?,?,?,?,?,?)";

	$stmt = mysqli_prepare($con, $saveActivityQuery);
	//mysqli_stmt_bind_param($stmt, 'ssssss', $data['desc'], $data['user_id'],$data['role'],$data['publicIP'],$user_agent,$data['privateIP']);
	mysqli_stmt_bind_param($stmt, 'sssssssss', $data['desc'], $data['user_id'],$data['role'],$ip_address,$user_agent,$ip_address_private,$data['city'],$data['region'],$data['location1']);
	
	$insertResult = mysqli_stmt_execute($stmt);
					
    }


}   