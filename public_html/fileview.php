<?php

class FileView {

private $name;
private $type;
private $size;
private $link;

public function __construct($a, $b, $c, $d) {		
$this -> name = $a;
$this -> type = $b;
$this -> size = $c;
$this -> link = $d;
}

public function getName(){
return $this -> name; 
}

public function getType(){
return $this -> type ;
}

public function getSize(){
return $this -> size; 
}

public function getLink(){
return $this -> link ;
}
}

?>