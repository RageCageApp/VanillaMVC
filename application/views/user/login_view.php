<div class="block bgWhite">
	<div class="content">
		<h1 style="font-size: 20px; font-weight: bold; margin-bottom:5px;">Vanila MVC Login</h1>
		<hr style="margin: 20px 0px;">	
		<div style="float: left;">
			<form method="post" action="/user/login">
				Email:<br>
				<input type="text" name="email">
				<br>
				Password:<br>
				<input type="password" name="password">
				<input type="submit" value="Login">				
			</form>	
			<?php echo $error;?>	
		</div>
	</div>
</div>