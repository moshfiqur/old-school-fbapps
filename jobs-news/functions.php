<?php

	require_once("appinclude.php");
	require_once("connection.php");
	
	// global variable declaration
	$eduString = "";
	$profileSQL = "";
	$jobSQL = "";
	$profileDataArr = array();
	
	########################################################################
	## profile specific data, which is fixed for every user
	########################################################################
	$profileDataArr['TXP_ID'] = NULL;
	$profileDataArr['source'] = "facebook";
	$profileDataArr['middleinitial'] = "";
	$profileDataArr['cellphone'] = "";
	$profileDataArr['homestate'] = "";
	$profileDataArr['companyname'] = "";
	$profileDataArr['companyurl'] = "";
	$profileDataArr['userwebsite'] = "";
	$profileDataArr['userblog'] = "";
	$profileDataArr['Skype'] = "";
	$profileDataArr['IM'] = "";
	$profileDataArr['industry'] = "";
	$profileDataArr['profile1'] = "";
	$profileDataArr['profile2'] = "";
	
	##############################
	$profileDataArr['job_ID'] = "";
	$profileDataArr['XUSR_ID'] = "";
	$profileDataArr['source'] = "";
	$profileDataArr['sourceID'] = "";
	$profileDataArr['firstname'] = "";
	$profileDataArr['middleinitial'] = "";
	$profileDataArr['lastname'] = "";
	$profileDataArr['email'] = "";
	$profileDataArr['phonenumber'] = "";
	$profileDataArr['cellphone'] = "";
	$profileDataArr['photo'] = "";
	$profileDataArr['companyname'] = "";
	$profileDataArr['title'] = "";
	$profileDataArr['hometown'] = "";
	$profileDataArr['homestate'] = "";
	$profileDataArr['homecountry'] = "";
	$profileDataArr['interest'] = "";
	$profileDataArr['education'] = "";
	#################################
	
	
	###########################################################################################################################################################
	##
	## array function getContactsDetails(array $profile)
	##
	###########################################################################################################################################################
	
	function getContactsDetails($profile){
	
		if(is_array($profile)){
		
			foreach($profile as $key => $value){
		
				global $profileDataArr;
					
				if($key == "first_name"){
					$profileDataArr['firstname'] = $value;
				}elseif($key == "last_name"){
					$profileDataArr['lastname'] = $value;
				}elseif($key == "pic"){
					$profileDataArr['photo'] = $value;
				}elseif($key == "religion"){
					$profileDataArr['hometown'] = $value;
				}elseif($key == "birthday"){
					$profileDataArr['homestate'] = $value;
				}elseif($key == "sex"){
					$profileDataArr['homecountry'] = $value;
				}elseif($key == "hometown_location"){
					$profileDataArr['interest'] = $value;
				}elseif($key == "relationship_status"){
					$profileDataArr['education'] = $value;
				}elseif($key == "political"){
					$profileDataArr['education'] .= "'" . $value;
				}elseif($key == "current_location"){
					$profileDataArr['education'] = ", " . $value . "<br/>";
				}elseif($key == "activities"){
					$profileDataArr['education'] = ", " . $value . "<br/>";
				}elseif($key == "interests"){
					$profileDataArr['education'] = ", " . $value . "<br/>";
				}elseif($key == "is_app_user"){
					$profileDataArr['education'] = ", " . $value . "<br/>";
				}elseif($key == "music"){
					$profileDataArr['education'] = ", " . $value . "<br/>";
				}elseif($key == "tv"){
					$profileDataArr['education'] = ", " . $value . "<br/>";
				}elseif($key == "movies"){
					$profileDataArr['education'] = ", " . $value . "<br/>";
				}elseif($key == "books"){
					$profileDataArr['education'] = ", " . $value . "<br/>";
				}elseif($key == "quotes"){
					$profileDataArr['education'] = ", " . $value . "<br/>";
				}elseif($key == "about_me"){
					$profileDataArr['about_me'] = ", " . $value . "<br/>";
				}
			
			} // end of foreach
			
		} // end of if
	
	} // end of function
	
	
	############################################################ END OF FUNCTION ##############################################################################
	
	
	###########################################################################################################################################################
	##
	## string function getWorkDetails(array $edu_details)
	##
	###########################################################################################################################################################
	
	function getWorkDetails($work_details){
	
		if(is_array($work_details) && !empty($work_details)){
		
			foreach($work_details as $key => $value){
			
				if(is_array($value)){
				
					getWorkDetails($value);
				
				}else{
				
					global $jobSQL;
					global $profileDataArr;
					
					if($key == "company_name"){
					
						$jobSQL .= "INSERT INTO t_txusr_jobs VALUES(null, '" . $_SESSION['job_ID'] . "', '" . $_SESSION['userID'] . "', '" . $value . "', ";
						
						if(empty($profileDataArr['companyname'])){
							$profileDataArr['companyname'] = $value;
						}
					
					}elseif($key == "position"){
					
						$jobSQL .= "'" . $value . "', ";
						
						if(empty($profileDataArr['title'])){
							$profileDataArr['title'] = $value;
						}
					
					}elseif($key == "description"){
					
						$jobSQL .= "'" . $value . "', ";
					
					}elseif($key == "start_date"){
					
						$jobSQL .= "'" . $value . " ";
					
					}elseif($key == "end_date"){
					
						if(empty($value)){
						
							$jobSQL .= "- Current' ) ";
							
						}else{
						
							$jobSQL .= "- " . $value . "' ) $$";
						
						}
					
					}
				
				}
			
			} // end of foreach
			
		} // end of if
	
	}
	
	############################################################ END OF FUNCTION ##############################################################################
	
	
	###########################################################################################################################################################
	##
	## string function getEducationDetails(array $edu_details)
	## 
	## This function takes a education_history array and convert into a education result string in a formatted way.
	##
	###########################################################################################################################################################
	
	function getEducationDetails($edu_details){
	
		global $eduString;
				
		if((is_array($edu_details)) && !empty($edu_details)){
		
			foreach($edu_details as $key1 => $value1){
			
				foreach($value1 as $key3 => $value3){
					
					if($key3 == "uid" && !empty($value3)){
					
						$user_id = $value3;
					
					}elseif($key3 == "education_history" && !empty($value3)){
					
						foreach($value3 as $key4 => $value4){
						
							foreach($value4 as $key5 => $value5){
							
								if(is_array($value5)){
								
									foreach($value5 as $key6 => $value6){
									
										$eduString .= $value6 . ", ";
									
									}
								
								}else{
								
									if($key5 == "name"){
									
										$eduString .= $value5;
										
										
									}elseif($key5 == "year"){
									
										$eduString .= "-" . $value5 . ", ";
										
									}else{
									
										$eduString .= $value5 . ", ";
									
									}
								
								}
					
							}
							
							$eduString .= ", ";
				
						}
						
					}
					
				}
				
			} // end of foreach
			
		} // end of if
	
	}
	
	############################################################ END OF FUNCTION ##############################################################################
	
	
	###########################################################################################################################################################
	##
	## function generateContactsDetailsSQL(array $profile)
	## 
	## 
	##
	###########################################################################################################################################################
	
	function generateContactsDetailsSQL(){
	
		global $profileDataArr;
		global $profileSQL;
		global $jobSQL;
		
		// Delete any existing profile data
		$qry = "DELETE FROM t_txuser_pro WHERE email = '" . $profileDataArr['email'] . "'";
		$result = @mysql_query($qry);
		
		$exJobSQL = array();
		
		$profileSQL .= "INSERT INTO t_txuser_pro VALUES(";
		
		$profileSQL .= "null";
		$profileSQL .= ",'" . $profileDataArr['job_ID'] . "'";
		$profileSQL .= ",'" . $profileDataArr['XUSR_ID'] . "'";
		$profileSQL .= ",'" . $profileDataArr['source'] . "'";
		$profileSQL .= ",'" . $profileDataArr['sourceID'] . "'";
		$profileSQL .= ",'" . $profileDataArr['firstname'] . "'";
		$profileSQL .= ",'" . $profileDataArr['middleinitial'] . "'";
		$profileSQL .= ",'" . $profileDataArr['lastname'] . "'";
		$profileSQL .= ",'" . $profileDataArr['email'] . "'";
		$profileSQL .= ",'" . $profileDataArr['phonenumber'] . "'";
		$profileSQL .= ",'" . $profileDataArr['cellphone'] . "'";
		$profileSQL .= ",'" . $profileDataArr['photo'] . "'";
		$profileSQL .= ",'" . $profileDataArr['companyname'] . "'";
		$profileSQL .= ",'" . $profileDataArr['title'] . "'";
		$profileSQL .= ",'" . $profileDataArr['hometown'] . "'";
		$profileSQL .= ",'" . $profileDataArr['homestate'] . "'";
		$profileSQL .= ",'" . $profileDataArr['homecountry'] . "'";
		$profileSQL .= ",'" . $profileDataArr['companyurl'] . "'";
		$profileSQL .= ",'" . $profileDataArr['userwebsite'] . "'";
		$profileSQL .= ",'" . $profileDataArr['userblog'] . "'";
		$profileSQL .= ",'" . $profileDataArr['Skype'] . "'";
		$profileSQL .= ",'" . $profileDataArr['IM'] . "'";
		$profileSQL .= ",'" . $profileDataArr['interest'] . "'";
		$profileSQL .= ",'" . $profileDataArr['education'] . "'";
		$profileSQL .= ",'" . $profileDataArr['industry'] . "'";
		$profileSQL .= ",'" . $profileDataArr['profile1'] . "'";
		$profileSQL .= ",'" . $profileDataArr['profile2'] . "'";
		
		$profileSQL .= ") ";
		
		$result = mysql_query($profileSQL);
		
		if($result){
			$job_ID = mysql_insert_id();
			$_SESSION['job_ID'] = $job_ID;
		}else{
			return false;
		}
		
		$exJobSQL = explode("$$", $jobSQL);
		//$exJobSQL = trim($exJobSQL);
		
		if(is_array($exJobSQL) && !empty($exJobSQL)){
			foreach($exJobSQL as $value){
			
				$result = mysql_query($value);
				/*
				if(!$result){
					echo mysql_error();
				}
				*/
			
			}
		}
		
		return true;
	
	} // end of function
	
	
	############################################################ END OF FUNCTION ##############################################################################
	
	
	###########################################################################################################################################################
	##
	## function exportProfile()
	## 
	## This function exports the logged in user profile. Return the exported filename on success and false on error
	##
	###########################################################################################################################################################
	
	function exportProfile($user){
	
		global $facebook;
		global $profileDataArr;
		global $profileJobArr;
		$profile = array();
		
		global $eduString;
		global $jobSQL;
		
		$profile = $facebook->api_client->users_getInfo(array($user), array('first_name', 'last_name', 'pic', 'religion', 'birthday', 'sex', 'hometown_location', 'relationship_status', 'political', 'current_location', 'activities', 'interests', 'is_app_user', 'music', 'tv', 'movies', 'books', 'quotes', 'about_me'));
		print_r($profile);
		die();
		getContactsDetails($profile);
				
		$eduString = "";
		$profile = $facebook->api_client->users_getInfo(array($user), array('education_history'));
		getEducationDetails($profile);
		//echo $eduString;
		$profileDataArr['education'] = $eduString;
		
		$workString = "";
		$profile = $facebook->api_client->users_getInfo(array($user), array('work_history'));
		getWorkDetails($profile);
		
		$flag = generateContactsDetailsSQL();
		
		return $flag;
		
		
	}
	
	
	############################################################ END OF FUNCTION ##############################################################################
			 
			 

?>