<?php

class Job_Admin {

private $j_title;
private $j_salary;
private $j_catname;
private $j_desc;
private $j_link;

public function __construct($a, $b, $c, $d, $e) {
$this -> j_title = $a;
$this -> j_salary ='&pound ' .$b; 
$this -> j_catname = $c; 
$this -> j_desc = $d; 
$this -> j_link = $e; 
}

public function getTitle(){
return $this -> j_title; 
}
public function getSalary(){
return $this -> j_salary ;
}

public function getCat(){
return $this -> j_catname ; 
}

public function getDesc(){
return $this -> j_desc ; 
}

public function getLink(){
return $this -> j_link ; 
}

}
?>