<div class="block bgWhite">
	<div class="content">
		<h1 style="font-size: 20px; font-weight: bold; margin-bottom:5px;">Vanila MVC Admin - View All Photos</h1>
		<hr style="margin: 20px 0px;">	
		<?php
		if(isset($photos) && is_array($photos)){
			foreach($photos as $photo){
				?>
					<a href="/photo/view/<?php echo $photo['photo_id'];?>">
					<img src="<?php echo $photo['path'];?>" height="100" width="100">
					</a>
					<?php echo $photo['email'];?>
					<br>
				<?php
			}
		}
		?>
	</div>
</div>