<div class="block bgWhite">
	<div class="content">
		<h1 style="font-size: 20px; font-weight: bold; margin-bottom:5px;">Vanila MVC - Photo View</h1>
		Photo ID: <?php echo isset($photo_data['photo_id']) ? $photo_data['photo_id'] : 'Can\'t find photo';?>
		<br>
		Owner Email: <?php echo isset($photo_data['email']) ? $photo_data['email'] : 'Can\'t find owner';?>
		<br>
		<?php 
			if(isset($photo_data['photo_id'])):
		?>
		<a href="/photo/delete/<?php echo $photo_data['photo_id'];?>">Delete</a>
		<?php
			endif;
		?>
		<hr style="margin: 20px 0px;">	
		<?php
		if(is_array($photo_data) && isset($photo_data['path'])){
			?>
			<img src="<?php echo $photo_data['path'];?>">
			<?php
		}
		?>
	</div>
</div>