<?php
class users { //clase que contiene los objetos de la base de datos


}

class Categoria{
  public $order;
  public $name;
  public $color;

  function __construct($dataArray) {
    //constructor vacio
    $this->order= $dataArray['ORDER'];
    $this->name=$dataArray['CATEGORY_NAME'];
    $this->color=$dataArray['COLOR'];
  }

}

class DatosUsuarios{ 
    public  $USER_ALIAS;
    public  $NAME;
    public  $FIRST_LAST_NAME;
    public  $SECOND_LAST_NAME; 
    public  $EMAIL; 
    public  $PHONE_NUMBER; 
    public  $BIRTHDAY; 
    public  $USER_TYPE; 
    public  $PROFILE_PICTURE;
 
    function __construct($dataArray) {
        //constructor vacio
        $this->USER_ALIAS= $dataArray['USER_ALIAS'];
        $this->NAME=$dataArray['NAME'];
        $this->FIRST_LAST_NAME=$dataArray['FIRST_LAST_NAME'];
        $this->SECOND_LAST_NAME=$dataArray['SECOND_LAST_NAME'];
        $this->EMAIL=$dataArray['EMAIL'];
        $this->PHONE_NUMBER= $dataArray['PHONE_NUMBER'];
        $this->BIRTHDAY= $dataArray['BIRTHDAY'];
        $this->USER_TYPE = $dataArray['USER_TYPE']; 
        $this->PROFILE_PICTURE = $dataArray['PROFILE_PICTURE'];
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
          return $this->$property;
        }
    }
    
      public function __set($property, $value) {
        if (property_exists($this, $property)) {
          $this->$property = $value;
        }
        return $this;
    }

      
}

?>

