<html>

<?php

if ((isset($_SESSION['super']))) 

{

	header ("Location: allusers.php");

}

if ((isset($_SESSION['user']))) 

{

	header ("Location: loginnext.php");

}

?>



<head>

	<title>Sign-Up</title>

<style>

#inputdata{

    width:500px;

    height:50px;

    font-size:11pt;

    border-style: solid;

    border-width: 5px;

    border-color: #7c70b8;

}

body {

    background-color: #8779C2;

	background :radial-gradient(#9f93ce,#6c609b);

}

label{

	font-size:20px;

    color:white;

}

#ast{

	color: red;

}

a{

    color:#ffffff;

	font-size:20px;

    padding-right: 2cm;

	font-family: Arial, Helvetica, Sans-serif;

    padding-top: 1cm;

}

img{

	padding-top:10px;

    padding-bottom:8px;

}

#link

{

	color:white;

    float:right;

	padding-top:20px;

    padding-bottom:7px;

    padding-left:120px;  

	font-family: Arial, Helvetica, Sans-serif;

}

#top

{

	width: 1350px;

	height: 50px;

	background : #2A2A2A;

	   overflow:hidden

}

#submit

{

width:500px;

padding: 10px 15px 10px ;

font-size: 20px;

border: 1px solid #ffbd00;

color: black;

background: linear-gradient(#ffd300,#ffa800);

text-shadow: 1px 1px #ffffff;

}



#ast{

	color: red;

}

#link

{

	color:white;

    float:right;

	padding-top:20px;

    padding-bottom:7px;

    padding-left:120px;  

}

table

{

	padding-top: 10px;

}

</style>

<script type="text/javascript">

function checkForm(form)

  {

    if(form.name.value == "")

	{

      alert("Please enter your name!");

      form.name.focus();

      return false;

    }

	if(form.email.value == "") 

	{

      alert("Please enter your email!");

      form.name.focus();

      return false;

    }

	if(form.password.value == "") 

	{

      alert("Please enter your password!");

      form.name.focus();

      return false;

    }

	var r = document.getElementsByName("radio");

	var c = -1;

	for(var i=0; i < r.length; i++)

	{

		if(r[i].checked) 

		{

			c = i; 

		}

   

	}

	if (c == -1){

		alert("Please select your gender");

		return false;

	}

	if(isNaN(form.phone.value))

    {

        alert("please enter only digits in phone number ");

        return false;

    }

	if(form.phone.value.length!=10) 

	{

		alert("Your phone number must be of 10 digits");

		return false;

	}

	return true;

  }



</script>

</head>

<body>

<div id="top">

&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

<img src="inno.png" height="40" width="190">

<div id="link"><a href="login.php">LOGIN</a></div>

</div>

<center>

<label><h2>Register Here</h2></label>

<table cellspacing="10">

<tr>

<form onsubmit="return checkForm(this)"  method="POST" >



<td> <input id="inputdata" type="text" name="name"  placeholder="Enter your name" REQUIRED /><div id="ast">*</div></td>

</tr>

<tr>

<td> <input id="inputdata" type="text" name="email" placeholder="Enter your email" REQUIRED ><div id="ast">*</div></td>

</tr>

<tr>

<td><label>Gender: </label><input type="radio" name="radio" value="Male"><label>Male </label>

<input type="radio" name="radio" value="Female"><label>Female</label></td>

</tr>

<tr>

<td> <input id="inputdata" type="text" name="phone" placeholder="Enter your phone number"  REQUIRED><div id="ast">*</div></td>

</tr>

<tr>

<td> <input id="inputdata" type="password" name="password" placeholder="Enter your password"  REQUIRED><div id="ast">*</div></td>

</tr>



<tr>

<td><input type="submit" name="submit" id="submit" value="Complete Sign-Up"></td>

</tr>

</form>

</table>

</center>

</div>

</div>

<?php

include('dbconnection.php');



$name=filter_var(@$_POST['name'], FILTER_SANITIZE_STRING);

$email=filter_var(@$_POST['email'], FILTER_SANITIZE_STRING);

$gender=filter_var(@$_POST['radio'], FILTER_SANITIZE_STRING);

$phone=filter_var(@$_POST['phone'], FILTER_SANITIZE_STRING);

$password=filter_var(@$_POST['password'], FILTER_SANITIZE_STRING);

$submit=@$_POST['submit'];

$pass=md5($password);



if($submit){

		if($name==true){

			if (!preg_match("/^[a-zA-Z ]*$/",$name)) {

				$nameErr = "Only letters and white space allowed"; 

				echo $nameErr;

			}

			else 

			{

				if($email==true)

				{

					if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 

					{

						$emailErr = "Invalid email format"; 

						echo $emailErr;

					}

					else 

					{

						if($phone==true)

						{

							if (!preg_match("/([0-9]{10})/",$phone) ) 

							{

								$contactErr = "Only digits allowed and it must be 10 digits"; 

								echo $contactErr;

							}

							else

							{

								if($password==true)

								{

									$sql = "SELECT * FROM registration WHERE email = '$email'";

									$result=$conn->query($sql);

									if ($result->num_rows > 0)

									{

										$txt2 = "This email id already exists";

										echo "<h3><center>" . $txt2 . "</center></h2>";

										exit;

										header ("Location: register.php");

									}

									else

									{

										$uname_arr = explode('@',$email);

										$uname = $uname_arr[0]; 

										$sql = "SELECT * FROM registration WHERE SUBSTRING_INDEX(SUBSTRING(email,1), '@', 1) = '$uname'";

										if($result=$conn->query($sql))

										{

										

											$countrows=$result->num_rows;

											if($countrows !=0)

											{

												

												$uname=$uname.'_'.$countrows;

											}

										}

										

										$sql = "INSERT INTO registration(name,email,username,gender,contact,password) values('$name','$email','$uname','$gender','$phone','$pass')";

										if ($conn->query($sql) === TRUE) 

										{

											$txt2 = "You can log in now.Your username is ".$uname;

											echo "<h3><center>" . $txt2 . "</center></h2>";

										} 

										else 

										{

											echo "Error: " . $sql . "<br>" . $conn->error;

										}

									}

								}

								else

								{

									echo 'please enter password';

								}

							}

						}

						else 

						{

							echo "Please enter contact";

						}

					}

				}

				else 

					echo "Please enter email";

			}

		}

		else echo "Please enter name";

};

?>

</body>

</html>
