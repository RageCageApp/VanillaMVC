<div class="block bgWhite">
	<div class="content">
		<h1 style="font-size: 20px; font-weight: bold; margin-bottom:5px;">Vanila MVC Registration</h1>
		<hr style="margin: 20px 0px;">	
		<div style="float: left;">
			<form method="post" action="/user/register">
				Email:<br>
				<input type="text" name="email">
				<br>
				Password:<br>
				<input type="password" name="password">
				<br>
				Re-type Password:<br>
				<input type="password" name="password2">

				<input type="submit" value="Login">					
			</form>	
			<?php echo $error;?>	
		</div>
	</div>
</div>