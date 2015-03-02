# VanillaMVC

I created this repo to address the following coding exercise:

You are writing a photo saving utility that has members and administrators. The purpose of this site is to allow users to come in, create an account, receive a verification email to activate the account, allow users to upload photos, see the photos they have uploaded and have some basic functions (cropping, resizing etc...). There is also an administrative interface where we can see all the photos, choose to search by user and some statistics as well (how many photos uploaded, number of users and so on).

Code shortcomings:

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