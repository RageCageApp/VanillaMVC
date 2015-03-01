<div class="block bgWhite">
	<div class="content">
		<h1 style="font-size: 20px; font-weight: bold; margin-bottom:5px;">Vanila MVC Registration</h1>
		<a href="/user/login">Login</a>
		<hr style="margin: 20px 0px;">	
		<div style="float: left;">
			<form method="post" action="/user/register">
				Email:<br>
				<input type="text" name="email" id="email">
				<br>
				Password:<br>
				<input type="password" name="password" id="password">
				<br>
				Re-type Password:<br>
				<input type="password" name="password2" id="password2">
				<br>
				<input type="radio" name="type" value="0" checked>User
				<input type="radio" name="type" value="1">Admin
				<input type="submit" value="Register" id="submit">					
			</form>	
			<?php echo $error;?>	
		</div>
	</div>
</div>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" ></script>
<script type="text/javascript">
$( document ).ready(function() {
    $('#submit').click(function(event){

    	if($('#email').val().length == 0) {
            alert("Email required");
            event.preventDefault();
        }

    	if($('#password').val().length == 0) {
            alert("Password required");
            event.preventDefault();
        }
        
        if($('#password').val() != $('#password2').val()) {
            alert("Password and Confirm Password don't match");
            
            event.preventDefault();
        } 
    });
});
</script>