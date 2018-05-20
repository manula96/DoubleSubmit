<?php

	
	session_start();
	//storing session id
	$sessionID=session_id();
	
	 //generate CSRF token
	if(empty($_SESSION['key']))  // creating the session key for csrf token
	{
		$_SESSION['key']=md5(uniqid(mt_rand(),true));    
	}
	
	$csrf = hash_hmac('sha256',$sessionID,$_SESSION['key']);  //creating csrf token
	$_SESSION['csrf']= $csrf;  // and storin it in session
	
	setcookie("session_id",$sessionID,time()+3600,"/","localhost",false,true);  //setting a cookie for session id
	setcookie("csrf",$csrf,time()+3600,"/","localhost",false,true); //setting a cookie for csrf token 

	
?>
<!DOCTYPE HTML>  
<html>
<head>
 
<style>
.error {color: #FF0000;}
</style>
</head>
<body> 


<h2>PHP Form Login Example</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="validate1.php">  
  
  Your Mail: <input type="text" name="email" id="email">
  <span class="error">* </span>
  <br></br>
  Password :  <input type="password" name="password" id="password">
  <span class="error">* </span>
  <br><br>
  <input type="checkbox" name="remember" value=1>
  Remember Me
  <br><br>
  <input type="hidden" id="cs" name="csrf" > <!--hidden DOM field-->

  <input type="submit" name="login" value="login">  
</form>

<script> document.getElementById("cs").value = '<?php echo $csrf; ?>' </script> <!-- Assign CSRF token to hidden variable --!>
                                                                                
<!-- retrieve email and password if selected "remember me" in previous enter-->

<?php
	if(isset($_COOKIE['email'])  )
	{	
		$email= $_COOKIE['email'];
		
		echo "<script>
			document.getElementById('email').value= '$email'
			

		</script>";
		echo "<script>
			document.getElementById('password').value= '$password'
			

		</script>";
	}
	
?>


</body>


</html>
