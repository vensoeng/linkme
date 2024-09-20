<?php

namespace src\controllers;

class AuthController
{
    public function signup()
    {
        // Handle signup logic
        require '../app/views/auth/signup.php';
    }

    public function login()
    {
        // Handle login logic
        require '../app/views/auth/login.php';
    }
}
