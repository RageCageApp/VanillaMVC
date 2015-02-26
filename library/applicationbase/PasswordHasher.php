<?php
//------THIS IS NOT A SAFE CLASS---------
/**
 * This class should not be used on a production server. Password hashing is a very complex science
 * and I am not a cryptographer. I do not have the skills to produce a safe, viable password hashing
 * class. However, for this coding exercise, this class will get the job done. 
 * In a real production environment, we can use open source password hashing libraries like phpass
 */
class PasswordHasher
{
    private $_salt;

    public function __construct()
    {
        $_salt = 'PAhBJKWN4hsOHwQPKH4S';
    }

    public function hashPassword($password)
    {
        $saltedPassword = $password.$this->_salt;
        return MD5($saltedPassword);
    }

    public function CheckPassword($password, $hashedPassword)
    {
        return ($this->hashPassword($password) == $hashedPassword) ? TRUE : FALSE;
    }
}