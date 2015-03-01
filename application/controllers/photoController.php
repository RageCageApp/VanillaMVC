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
		if(isset($_POST["submit"])) {
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
		}
	}
}