<?php

namespace App\Helpers;

use App\Models\User;

class AuthHelper
{
    public function logout()
	{
		unset($_SESSION['user']);
    }
    
    public function attempt($name, $password)
    {
        $user = User::findByName($name);

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user["password"])) {
            $_SESSION['user'] = $user['_id'];
            return true;
        }

        return false;
    }

    public function check()
	{
    	return isset($_SESSION['user']);
    }
    
    public function user()
	{
        return User::findByID($_SESSION['user']);
	}
}
