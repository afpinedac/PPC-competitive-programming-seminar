<?php

class usuario {

    private $userName;
    private $password;
    private $name;
    private $lastName;
    private $rol;

    function __construct($userName, $pass, $rol, $n) {
        $this->username = $username;
        $this->password = $pass;
        $this->rol = $rol;
    }

    function getUserName() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }
    
     function getRol() {
        return $this->rol;
    }

    function setUserName($userName) {
        $this->userName = $userName;
    }

    function setPassword($pass) {
        $this->password = $pass;
    }
    
    function setRol($rol) {
        $this->password = $rol;
    }

}

?>
