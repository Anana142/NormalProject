<?php


namespace App\Controllers;

trait Auth
{
    public function checkAuth() : bool
    {
        if(isset($_SESSION['username']))
            return true;
        else
            return false;
    }
    public function signIn(string $username, int $id){
        $_SESSION['username'] = $username;
        $_SESSION['userid'] = $id;
    }
    public function  signOut(){
        unset($_SESSION['username']);
        unset($_SESSION['userid']);
    }
}