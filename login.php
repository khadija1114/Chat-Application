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
	
	input[type='text'],input[type='password'],input[type='submit']{
		padding: 10px;
		margin: 10px;
		width: 98%;
		border-radius: 5px;
		border: solid thin grey;
	}

	input[type='submit']{
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
			<div style="font-size: 20px; font-family: nameFont;" > Login </div>
		</div>


		<div id="error" style=""> see text </div>


		<form id="myform">
			
			<input type="text" name="email" placeholder="E-mail"> <br>
			<input type="password" name="password" placeholder="Password"> <br>
			<input type="submit" value="Login" id="login_button"> <br>

			<br> 
			<!-- <div style = "text-align: center;"> Don't have an account?
			<a href="signup.php" style = "text-align: center; text-decoration: none;"> Signup  </a> here </div> -->
			
			<a href="signup.php" style = "display: block;text-align: center; text-decoration: none;"> Don't have an account? Signup here </a>


		</form>
	</div>

</body>
</html>


<script type="text/javascript">

 	

	var login_button = document.getElementById("login_button");

	// collect data function
	login_button.addEventListener("click",function(e){
		
		e.preventDefault();
		login_button.disabled = true;
		login_button.value = "Loading... Please wait";

		var myform = document.getElementById("myform");
		var inputs = myform.getElementsByTagName("INPUT");
	

		var data = {};		

		for (var i = inputs.length - 1; i >= 0; i--) {
			var key = inputs[i].name;

			switch(key) {
			
			case "email":
				data.email = inputs[i].value;
				break;

			case "password":
				data.password = inputs[i].value;
				
			}
		} 

		send_data(data, "login");


		/*testing 

		alert(JSON.stringify(data)); 
		*/

	});
	
	
	function send_data(data, type) {

		var xml = new XMLHttpRequest();

		xml.onload = function(){
			if (xml.readyState == 4 || xml.status == 200) {
				handle_result(xml.responseText);
				login_button.disabled = false;
				login_button.value = "Login";
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