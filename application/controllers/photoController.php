<?php
class photoController extends Controller {   

	public function __construct($controller,$action) 
	{ 
		// Load core controller functions 
		parent::__construct($controller, $action); 

		// Load models
		$this->load_model('UserAuth');
		$this->load_model('photoModel');
	}

	/**  
	 * View photo
	 *
	 * @return void
	 */
	public function view($photo_id = NULL)
	{
		if($this->get_model('UserAuth')->isLoggedIn())
		{
			if(is_numeric($photo_id))
			{
				$data['photo_data'] = $this->get_model('photoModel')->get_photo($photo_id);
				$this->get_view()->render('photo/photo_view', $data);
			}

		} else {
			HelperFunctions::redirect('user/index');
		}
	}

	/**  
	 * View all photos
	 *
	 * @return void
	 */
	public function view_all()
	{
		if($this->get_model('UserAuth')->isLoggedIn() 
			&& $this->get_model('UserAuth')->isAdmin($this->get_model('UserAuth')->get_logged_in_user_id()))
		{
			$data['photos'] = $this->get_model('photoModel')->get_all_photos();
			$this->get_view()->render('photo/view_all', $data);

		} else {
			HelperFunctions::redirect('user/index');
		}
	}

	/**
	 * Delete photo
	 *
	 * @return void
	 */
	public function delete($photo_id = NULL)
	{
		if($this->get_model('UserAuth')->isLoggedIn())
		{
			if(is_numeric($photo_id))
			{
				$logged_in_id = $this->get_model('UserAuth')->get_logged_in_user_id();

				if($this->get_model('photoModel')->delete($photo_id, $logged_in_id))
					HelperFunctions::redirect('user/index');

				else
					echo 'You do not have the priveleges to delete that photo.';
			
			} else {
				echo 'Photo ID is not valid';
			}
		
		} else {
			HelperFunctions::redirect('user/index');
		}
	}

	/**
	 * Upload Photo
	 *
	 * @return void
	 */
	public function upload()
	{
		$target_folder = "public/uploads/";

		$target_dir = ROOT . DS . $target_folder;
		
		//Create Unique Name for file being uploaded
		$sessid = '';
		while (strlen($sessid) < 32)
		{ 
			$sessid .= mt_rand(0, mt_getrandmax());
		}
		$target_name = md5(uniqid($sessid, TRUE)) . '.' . strtolower(pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION));
		$target_file = $target_dir . $target_name;
		
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		//Target url of new file
		$path_to_new_file = "http://" . $_SERVER['HTTP_HOST'] . "/" . $target_folder . $target_name;
		
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"]) && strlen($_FILES["fileToUpload"]["tmp_name"]) > 0) {
		    if(getimagesize($_FILES["fileToUpload"]["tmp_name"]) !== false) { 	// actual image file
				if($imageFileType == "jpg" 
					|| $imageFileType == "png" 
					|| $imageFileType == "jpeg"
					|| $imageFileType == "gif" ) {				// accepted file format
						if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {	// move file to appropriate folder
					        $this->get_model('photoModel')->create_new_photo($path_to_new_file, $this->get_model('UserAuth')->get_logged_in_user_id());
					        HelperFunctions::redirect('user/index');

					    } else {
					        echo "Sorry, there was an error uploading your file.";
					    }

				} else {										// not accepted file format
					echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				}
		    } else {															// not an actual image file
		        echo "File is not an image.";
		    }
		} else {
			echo "Please select an image to upload";
		}
	}
}