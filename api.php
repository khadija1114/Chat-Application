<?php

session_start();


$DATA_RAW =  file_get_contents("php://input");
$DATA_OBJ = json_decode($DATA_RAW); //string to object


//check if logged in
$info = (object)[];
if (!isset($_SESSION['userid'])) {

	if (isset($DATA_OBJ->data_type) && ($DATA_OBJ->data_type!= "login") && ($DATA_OBJ->data_type!= "signup")){

		$info->logged_in = false;
		echo json_encode($info);
		die;
	}
	
}


require_once("classes/autoload.php");
$DB = new Database();

$Error = "";

//process the data
if(isset($DATA_OBJ->data_type) && ($DATA_OBJ->data_type == "signup")) {

	//signup
	include("includes/signup.php");
	
} elseif (isset($DATA_OBJ->data_type) && ($DATA_OBJ->data_type == "login")){

	//login
	include("includes/login.php");

} elseif (isset($DATA_OBJ->data_type) && ($DATA_OBJ->data_type == "logout")){

	//logout
	include("includes/logout.php");

} elseif (isset($DATA_OBJ->data_type) && ($DATA_OBJ->data_type == "user_info")){

	//user_info
	include("includes/user_info.php");

} elseif (isset($DATA_OBJ->data_type) && ($DATA_OBJ->data_type == "contacts")){

	//contacts
	include("includes/contacts.php");

} elseif (isset($DATA_OBJ->data_type) && ($DATA_OBJ->data_type == "chats" || $DATA_OBJ->data_type == "chats_refresh")){

	//chats
	include("includes/chats.php");

} elseif (isset($DATA_OBJ->data_type) && ($DATA_OBJ->data_type == "settings")){

	//settings
	include("includes/settings.php");

} elseif (isset($DATA_OBJ->data_type) && ($DATA_OBJ->data_type == "save_settings")){

	//save_settings
	include("includes/save_settings.php");

} elseif (isset($DATA_OBJ->data_type) && ($DATA_OBJ->data_type == "send_message")){

	//send_message
	include("includes/send_message.php");
	
} elseif (isset($DATA_OBJ->data_type) && ($DATA_OBJ->data_type == "delete_message")){

	//delete_message
	include("includes/delete_message.php");
	
} elseif (isset($DATA_OBJ->data_type) && ($DATA_OBJ->data_type == "delete_thread")){

	//delete_thread
	include("includes/delete_thread.php");
	
}


// row = data
function message_left($data, $row) {

	$image = "ui/images/user.jpg";
	if (file_exists($row->image)){
		$image = $row->image;
	}


	$a = "

	<div id = 'message_left' >
		
		<img id = 'prof_img' src = '$image'>
		<b style = 'font-size: 13px; color: #eee;'>$row->username</b><br>
		$data->message<br>";

		if ($data->files != "" && file_exists($data->files)) {
			$a .= "<img src = '$data->files' style = 'width: 100%;cursor: pointer;' onclick = 'image_show(event)'/> <br>";

		}
		
		$a .= "<span style = 'font-size:11px; color:white;'> ". date("jS M Y H:i:s a", strtotime($data->date)) ." </span>
		<img id = 'trash' src ='ui/icons/trash.png' onclick='delete_message(event)' msgid = '$data->id'/>
	</div> ";

	return $a;

} 


function message_right($data, $row) {

	$image = "ui/images/user.jpg";
	if (file_exists($row->image)){
		$image = $row->image;
	}

	$a = "<div id = 'message_right' >
		<div> ";

	if ($data->seen) {
		$a .= "<img src='ui/icons/tick_blue.png' style ='' />";
	} elseif ($data->received) {
		$a .= "<img src='ui/icons/tick_black.png' style ='' />";
	}

	$a .= "
	 </div>
	<img id = 'prof_img' src = '$image' style = 'float: right;'>
	<b style = 'font-size: 13px; color: #999;'>$row->username</b><br>
	$data->message<br>";

	if ($data->files != "" && file_exists($data->files)) {
			$a .= "<img src = '$data->files' style = 'width: 100%; cursor: pointer;' onclick = 'image_show(event)'/> <br>";

		}

	$a .= "
	<span style = 'font-size:11px; color:#aaa;'>".date("jS M Y H:i:s a", strtotime($data->date)) ."</span>

	<img id = 'trash' src ='ui/icons/trash.png' onclick='delete_message(event)' msgid = '$data->id'/>
	</div>";

	return $a;

} 

function message_controls() {

	return "

	</div>
	<span onclick='delete_thread(event)' style = 'color: red; cursor: pointer;margin-left: 170px; font-size:13px;'> Delete this conversation </span>

	<div style = 'display:flex; width = 100%; height: 60px;'>
		<label for='message_file'> <img src = 'ui/icons/clip.png' style = 'opacity:0.7; width: 30px; margin-top:15px; margin-left:5px; cursor:pointer;'> </label>
		<input type = 'file' id = 'message_file' name = 'file' style = 'display:none;' onchange='send_image(this.files)'/>
		<input id = 'message_text' onkeyup='enter_pressed(event)' style = 'flex:6;border:solid thin #ccc; border-bottom: none;' type = 'text' placeHolder = 'type your message'/>
		<input style = 'flex:1; margin:10px; cursor: pointer;' type = 'button' value = 'send' onclick = 'send_message(event)'/>
	</div>

</div>
";

} 



/*testing

echo $myobject-> gender;
die; // just like return in C

echo "<pre>";
print_r($myobject); //print readable
echo "</pre>";
*/



