<?php


$id = $_SESSION['userid'];
$sql = "select * from users where userid = :userid limit 1";
$data = $DB->read($sql, ['userid'=>$id]);

if (is_array($data)){

	$data = $data[0];

	//image selection
	$image = "ui/images/user.jpg";
	if (file_exists($data->image)){
		$image = $data->image;
	}

	//gender selection
	$gender_male = "";
	$gender_female = "";
	$gender_other = "";

	if ($data->gender =="Male"){

		$gender_male = "checked";

	} else if ($data->gender == "Female") {

		$gender_female = "checked";

	} else {

		$gender_other = "checked";

	}



	$mydata = '

		<style type="text/css">


			@keyframes appear{

				0%{
					opacity:0;
					transform: translateY(50px)
				}
				100%{
					opacity:1;
					transform: translateY(0px)
				}

			}


			form{
				text-align: left;
				margin: auto;
				padding: 10px;
				width: 100%;
				max-width: 400px;
			}
			
			input[type="text"],input[type="password"],input[type="button"]{
				padding: 10px;
				margin: 10px;
				width: 200px;
				border-radius: 5px;
				border: solid thin grey;
			}

			input[type="button"]{
				width: 220px;
				padding: 10px;
				cursor: pointer;
				background-color: #2b5488;
				color: white;
			}	

			input[type="radio"]{
				transform: scale(1.2);
				cursor: pointer;
			}

			#error{
				text-align: center;
				padding: 0.5em;
				background-color: #ecaf91;
				color: white;
				display: none;
			}

			.dragging{
				border: dashed 2px #aaa;
			}

		</style>

			

		<div id="error" style=""> error </div>

		<div style = "display:flex; animation: appear 0.75s ease">

			<div>
			<img ondragover = "handle_drag_and_drop(event)" ondragleave = "handle_drag_and_drop(event)"  ondrop = "handle_drag_and_drop(event)"   src ="'.$image.'" style = "width: 200px; height:200px; margin: 16px;"/>
			
			<div style = "margin-left: 40px; font-size: 15px;">drag and drop image or</div> <br>
			<input type="file" onchange="upload_profile_image(this.files)" id="change_image_input" style="margin-left:25px;">
			

			<label id="change_image_button" for = "change_image_input" style = "background-color: #9b9a80; display: inline-block; border-radius: 5px; cursor: pointer; padding: 0.5em;margin-left: 50px;">

				Change Image

			</label>

			
			</div>

			<form id="myform">

				
				<input type="text" name="username" placeholder="Username" value = "'.$data->username.'"> <br>
				<input type="text" name="email" placeholder="E-mail" value = "'.$data->email.'"> <br>

				<div style="padding: 10px;">
					Gender:<br>
					<input type="radio" value="Male" name="gender" '.$gender_male.'> Male <br>
					<input type="radio" value="Female" name="gender" '.$gender_female.'> Female <br>
					<input type="radio" value="Other" name="gender" '.$gender_other.'> Other <br>
				</div>

				<input type="password" name="password" placeholder="Password" value = "'.$data->password.'"> <br>
				<input type="password" name="password2" placeholder="Retype Password" value = "'.$data->password.'"> <br>
				<input type="button" value="Save Settings" id="save_settings_button" onclick = "collect_data(event)"> <br>

				
			</form>
		</div>

	';




$info->message = $mydata;
$info->data_type = "contacts";
echo json_encode($info);


} else {

	$info->message = "No contacts were found!";
	$info->data_type = "error";
	echo json_encode($info);	
}



/* to change browse format <label id="change_image_button" style = "background-color: #9b9a80; display: inline-block; padding: 0.7em; border-radius: 5px; cursor: pointer; margin-left: 50px;">
				Change Image 
				<input type="file" value="Change Image" id="change_image_input" style = "display:none;">
			</label> --> */