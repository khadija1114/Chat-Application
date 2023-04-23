<?php

$info = (Object)[];

$data = false;
	$data['userid'] = $DB->generate_id(20);

	// validate username
	$data['username'] = $DATA_OBJ->username;
	if (empty($DATA_OBJ->username)){
		$Error .= "Enter a valid username. <br>";
	} else {
		if (strlen($DATA_OBJ->username) < 2){
			$Error .= "username must have 2 characters. <br>";
		} if (!preg_match("/^[a-z A-Z 0-9]*$/", $DATA_OBJ->username)){
			$Error .= "Username must not contain special characters. <br>";
		}
	}

	//validate email
	$data['email'] = $DATA_OBJ->email;
	if (empty($DATA_OBJ->email)){
		$Error .= "Enter a valid email. <br>";
	} else if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $DATA_OBJ->email)){
			$Error .= "Please enter a valid email. <br>";
	}


	// vallidate gender
	$data['gender'] = isset($DATA_OBJ->gender) ? ($DATA_OBJ->gender) : null;
	if (empty($DATA_OBJ->gender)){

		$Error .= "Please select a gender. <br>";
	}


	$data['password'] = $DATA_OBJ->password;
	if (empty($DATA_OBJ->password)){
		$Error .= "Enter a valid password. <br>";
	} else {
		if ($DATA_OBJ->password != $DATA_OBJ->password2){
			$Error .= "Retype password does not match. <br>";
		} if (strlen($DATA_OBJ->password) < 8){
			$Error .= "password must have 8 characters. <br>";
		}
	}


	$data['date'] = date("Y-m-d H:i:s");
	$password = $DATA_OBJ->password2;
	//$data['gender'] = $DATA_OBJ->gender;



	if ($Error == "") {
		$query = "insert into users (userid,username,gender,email,password,date) values (:userid,:username,:gender,:email,:password,:date)";
		$result = $DB->write($query, $data);

		if ($result) {
			$info->message = "your profile is created";
			$info->data_type = "info";
			echo json_encode($info);
		} else {
			$info->message = "your profile is NOT created";
			$info->data_type = "error";
			echo json_encode($info);
		}	
	} else {
		//echo "error occured";
		$info->message = $Error;
		$info->data_type = "error";
		echo json_encode($info);

	}
