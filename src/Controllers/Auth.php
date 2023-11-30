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
    public function checkAuthUser() : bool
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'user')
            return true;
        else
            return false;
    }
    public function checkAuthAdmin() : bool
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin')
            return true;
        else
            return false;
    }


    public function signIn(string $username, int $id){
        $_SESSION['username'] = $username;
        $_SESSION['userid'] = $id;
        $_SESSION['role'] = 'user';
    }
    public function signInAdmin(string $username, int $id){
        $_SESSION['username'] = $username;
        $_SESSION['userid'] = $id;
        $_SESSION['role'] = 'admin';
    }
    public function  signOut(){
        unset($_SESSION['username']);
        unset($_SESSION['userid']);
        unset($_SESSION['role']);
    }
    public function  signOutAdmin()
    {
        unset($_SESSION['username']);
        unset($_SESSION['userid']);
        unset($_SESSION['role']);
    }

    public function LogUser(){
        if(isset($_SESSION['username']))
            echo($_SESSION['username']);
        else
            echo('Не авторизирован!');
    }
}