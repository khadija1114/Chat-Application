<!DOCTYPE html>
<html>

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ChatA</title>

</head>

<style type="text/css">

	@font-face{
		font-family: headFont;
		src: url(ui/fonts/Summer-Vibes-OTF.otf);
	}
	@font-face{
		font-family: nameFont;
		src: url(ui/fonts/OpenSans-Regular.ttf);
	}


	#wrapper{
		max-width: 900px;
		min-height: 500px;
		margin: auto;
		color: grey;
		font-size: 18px;
	}

	form{
		margin: auto;
		padding: 10px;
		width: 100%;
		max-width: 400px;
	}
	
	input[type='text'],input[type='password'],input[type='button']{
		padding: 10px;
		margin: 10px;
		width: 98%;
		border-radius: 5px;
		border: solid thin grey;
	}

	input[type='button']{
		width: 103%;
		cursor: pointer;
		background-color: #2b5488;
		color: white;
	}	

	input[type='radio']{
		transform: scale(1.2);
		cursor: pointer;
	}

	#header{
		background-color: #4a5970;
		font-size: 45px;
		font-family: headFont;
		text-align: center;
		width: 100%;
		color: white;
	}

	#error{
		text-align: center;
		padding: 0.5em;
		background-color: #ecaf91;
		color: white;
		display: none;
	}

</style>

<body>

	<div id="wrapper">
		
		<div id='header'> MyChat 
			<div style="font-size: 20px; font-family: nameFont;" > Signup </div>
		</div>


		<div id="error" style=""> see text </div>


		<form id="myform">
			
			<input type="text" name="username" placeholder="Username"> <br>
			<input type="text" name="email" placeholder="E-mail"> <br>

			<div style="padding: 10px;">
				Gender:<br>
				<input type="radio" value="Male" name="gender_male"> Male <br>
				<input type="radio" value="Female" name="gender_female"> Female <br>
				<input type="radio" value="Other" name="gender_other"> Other <br>
			</div>

			<input type="password" name="password" placeholder="Password"> <br>
			<input type="password" name="password2" placeholder="Retype Password"> <br>
			<input type="button" value="Sign up" id="signup_button"> <br>

			<br>
			<a href="login.php" style = "display: block;text-align: center; text-decoration: none;"> Already have an account? Login here </a>
		</form>
	</div>

</body>
</html>

<!-- <script> alert("alada print kori"); </script>-->

<script type="text/javascript">

 	/*JSON: javascript object notation, how to declare and use

	var person = {}; person.name = "name"; person.age = 20;
	var person = {name:"name", age: 100};
	console.log(person);

	object to string: var s = JSON.stringify(objectName); for php json_encode()
	string to object: var o = JSON.parse(s); for php json_decode()

	*/

	var signup_button = document.getElementById("signup_button");

	// collect data function
	signup_button.addEventListener("click",function(){
		

		signup_button.disabled = true;
		signup_button.value = "Loading... Please wait";

		var myform = document.getElementById("myform");
		var inputs = myform.getElementsByTagName("INPUT");


		var data = {};		

		for (var i = inputs.length - 1; i >= 0; i--) {
			var key = inputs[i].name;

			switch(key) {
			case "username":
				data.username = inputs[i].value;
				break;

			case "email":
				data.email = inputs[i].value;
				break;

			case "gender_male":
			case "gender_female":
			case "gender_other":
				if (inputs[i].checked)
					data.gender = inputs[i].value;
				break;

			case "password":
				data.password = inputs[i].value;
				break;

			case "password2":
				data.password2 = inputs[i].value;

			}
		} 


		send_data(data, "signup");


		//testing 
		//alert(JSON.stringify(data)); 
		

	});
	
	
	function send_data(data, type) {

		var xml = new XMLHttpRequest();

		xml.onload = function(){
			if (xml.readyState == 4 || xml.status == 200) {
				handle_result(xml.responseText);
				signup_button.disabled = false;
				signup_button.value = "Signup";
			}
		}

		data.data_type = type;
		var data_string = JSON.stringify(data); // object to string

		xml.open("POST","api.php",true);
		xml.send(data_string);
	}

	function handle_result(result){

		//alert(result);
		var data = JSON.parse(result);

		if (data.data_type == 'info') {

			window.location = "index.php";

		} else {

			var error = document.getElementById("error");
			error.innerHTML = data.message;
			error.style.display = "block";
		}
	}
	
</script>