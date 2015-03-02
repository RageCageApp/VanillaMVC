VanillaMVC
================

Project Overview
================
The following code exercise was meant to address a coding exercise of Pixafy. It is by no means a realistic application deployable in the real world (Please see Code Shortcomings section below). Instead, this exercise was meant to showcase my understanding of php and my knowledge of how MVC frameworks operate.

Task #1 - User Creation
-----------
Required:

•	Create a homepage with a login and registration form. - DONE

•	Allow a user to register with an email and password - DONE

•	Allow a user to login using email and password - DONE

•	Automatically redirect from the homepage to a dashboard page if the user is logged in. - DONE

Bonus: 

•	Add confirm password functionality to the registration form and use javascript to prevent registration unless the passwords match. - DONE

•	Specify whether a user is an administrator or standard user - DONE

Mega Bonus: 

•	Use javascript validation to ensure both forms cannot be submitted unless all fields are not blank - DONE

Task #2 - User Dashboard
-----------
Required:

•	Display user's email address - DONE

•	Allow user to upload an image - DONE

•	View all images that a user has uploaded – DONE

•	Delete an image - DONE

•	Redirect the user back to the dashboard after an upload or deletion - DONE

Bonus:

•	Allow users to change their e-mail address - DONE

•	Allow users to specify the order in which the images are displayed, and display them in that order

•	Delete multiple images at a time

Mega Bonus:

•	Use Ajax to delete an image from the database and the page without refreshing

Task #3 - Admin Dashboard
-----------
Required:

•	View all photos from all users - DONE

•	View all photos from a specific user - DONE

•	Display the email address that each photo belongs to - DONE

Bonus:

•	Filter multiple users at a time

•	Prevent non-admin users from accessing the page - DONE

Mega Bonus:

•	Allow the admin to transfer ownership of multiple images to multiple users. Keep in mind that one image cannot be owned by multiple users.


Code shortcomings
-----------
lacks namespacing to prevent collisions of class names and function names

password hashing class is not safe

add CSRF tokens to forms to protect against cross-site request forgeries

need to match IP of session to increase security and prevent cookie hijacking

session table needs garbage collection

need better security class/functions to sanitize user input

need form input validation to make sure user inputs are of correct type and format

since activation key is a random int. people can use brute force to activate their account. just keep trying activate link with different numbers until they get the right one.

needs better error handling… don’t kill app if you run into an error like being unable to update session data.

lacks feature that allows user to request another activation email

lacks anti-virus and xss clean of photo uploaded

Local Setup
================
1) Use the sql file to create the tables in your local mysql database

2) Input the correct database details in config.php