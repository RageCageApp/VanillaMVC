<div class="block bgWhite">
	<div class="content">
		<h1 style="font-size: 20px; font-weight: bold; margin-bottom:5px;">Vanila MVC - Admin Dashboard</h1>
		All Users: <br>
		<?php
		if(isset($users) && is_array($users)){
			foreach($users as $user){
				?>
					<a href="/user/view_user/<?php echo $user['id'];?>">
					<?php echo $user['email'];?>
					</a>
					<br>
				<?php
			}
		}
		?>
		<hr style="margin: 20px 0px;">	
		All Photos: <br>
		<?php
		if(isset($photos) && is_array($photos)){
			foreach($photos as $photo){
				?>
					<a href="/photo/view/<?php echo $photo['photo_id'];?>">
					<img src="<?php echo $photo['path'];?>" height="100" width="100">
					</a>
				<?php
			}
		}
		?>
	</div>
</div>