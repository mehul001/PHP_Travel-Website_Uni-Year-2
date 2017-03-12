<?php

class Application {

private $a_name;
private $a_surname;
private $a_address;
private $a_number;
private $a_email;
private $a_cover;

public function __construct($a, $b, $c, $d, $e, $f) {		
$this -> a_name = $a;
$this -> a_surname = $b;
$this -> a_address = $c;
$this -> a_number = $d;
$this -> a_email = $e;
$this -> a_cover = $f;
}

public function getName(){
return $this -> a_name; 
}

public function getSurname(){
return $this -> a_surname ;
}

public function getAddress(){
return $this -> a_address; 
}

public function getNumber(){
return $this -> a_number ;
}

public function getEmail(){
return $this -> a_email; 
}
public function getCover(){
return $this -> a_cover ;
}

}

?>