<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
ob_start();
if(!isset($_SESSION['system'])){
	$system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
	foreach($system as $k => $v){
		$_SESSION['system'][$k] = $v;
	}
}
ob_end_flush();
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $_SESSION['system']['name'] ?></title>
 	

<?php include('./header.php'); ?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>

</head>
<style>
	body{
   max-height: 40%;
	max-width: 40%;
	max-height: 50px;
	background-image: url(images/img-5.jpg);
	background-repeat: no-repeat;
	position: relative;
	background-size: cover;
	margin: auto;
	    

	    /*background: #007bff;*/
	}
	.container {
		width: 650px;
      	height: 50px;
		position: absolute;
		text-align: center;
		margin: auto;
		margin-left: 500px; 
		margin-top: -500px;
        padding: 0;
	}

	 .logo-img {
		height: 600px;
    	width: 600px: 
		margin-top: -1000px;
		margin-left: -800px;
		position: right;
	}	


	#login-center .card{
	
		
	
		
	}


.card {
	
	width: 400px;
	height: 450px;
	background-color: rgba(44, 62, 80,0.7);
	
	padding-top: 20px;
	border: 1px;
	border-radius: 5px;
	box-shadow: 1px 1px 10px 7px grey;
}
 .control-label {
	color: white;
 }
 


 .form-group {
	position: center;
	padding-top: 20px;
	border-shadow: 1px 3px 2px 1px grey;
 }

 .form-group-1 {
	background-color: none;
	padding-top: 20px;
	text-align: center;

	
 }

 .login-txt {
	color: white;  
  }

  @media screen and (max-width: 600px) {
	.container { 
		flex-direction: column;
		
	}
  }
</style>

<body>
<div class="logo-img">
<img src="images/logo-1.png" style="margin-top: -100px; margin-left: 270px; width: 800px; height: 800px;"></a>
</div>
<div class="container">
		<div class="card col-md-8">
			  
  				<div class="card-body">
				 
  					<form id="login-form" >
  						<div class="form-group">
							<div class="login-txt">
						  <h1 class= "text-center-white">LOGIN</h1>
                             </div>
						  <div class=form-group-1>
							
							<label for="username" class="control-label">Username</label>
  							<input type="text" id="username" name="username" class="form-control" placeholder="Enter Username">
  						    </div>
  						    <div class="form-group-1">
  							<label for="password" class="control-label">Password</label>
  							<input type="password" id="password" name="password" class="form-control" placeholder="Enter Password">
  						    </div>
						</div>
  						<center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary">Login</button></center>
  					</form>
  				</div>
  		</div>
</div>
  		
    

  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				console.log('--------------------------');
				console.log(resp);
				console.log('--------------------------');
				if(resp == 1 || resp == 2){
					location.href ='index.php?page=home';
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>	
</html>