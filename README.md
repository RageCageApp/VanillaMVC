# VanillaMVC
MVC Framework created from scratch

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