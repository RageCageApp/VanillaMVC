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

    	var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    	
    	if(!pattern.test($('#email').val())){
    		alert("Enter a valid email please.");
            event.preventDefault();
    	}

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