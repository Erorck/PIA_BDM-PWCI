<?php

class Articulo{
  public $ARTICLE_ID;
	public $EVENT_DATE;
	public $LOCATION_STREET;
	public $LOCATION_NEIGHB;
  public $LOCATION_CITY;
  public $LOCATION_STATE;
  public $LOCATION_COUNTRY;
  public $ARTICLE_HEADER;
  public $ARTICLE_DESCRIPTION;
  public $ARTICLE_CONTENT;
  public $SIGN;
  public $CREATED_BY;
  public $LAST_UPDATED_BY;
  public $ARTICLE_STATUS;

  function __construct($dataArray) {
    $this->ARTICLE_ID           = $dataArray['ARTICLE_ID'];
    $this->EVENT_DATE           = $dataArray['EVENT_DATE'];
    $this->LOCATION_STREET      = $dataArray['LOCATION_STREET'];
    $this->LOCATION_NEIGHB      = $dataArray['LOCATION_NEIGHB'];
    $this->LOCATION_CITY        = $dataArray['LOCATION_CITY'];
    $this->LOCATION_STATE       = $dataArray['LOCATION_STATE'];
    $this->LOCATION_COUNTRY     = $dataArray['LOCATION_COUNTRY'];
    $this->ARTICLE_HEADER       = $dataArray['ARTICLE_HEADER'];
    $this->ARTICLE_DESCRIPTION  = $dataArray['ARTICLE_DESCRIPTION'];
    $this->ARTICLE_CONTENT      = $dataArray['ARTICLE_CONTENT'];
    $this->SIGN                 = $dataArray['SIGN'];
    $this->CREATED_BY           = $dataArray['CREATED_BY'];
    $this->LAST_UPDATED_BY      = $dataArray['LAST_UPDATED_BY'];
    $this->ARTICLE_STATUS       = $dataArray['ARTICLE_STATUS'];
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

class Categoria{
  public $order;
  public $name;
  public $color;

  function __construct($dataArray) {
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

class Media{ 
  public $DESCRIPTION;
  public $CONTENT;
  public $ROUTE;
  public $UPLOAD_DATE;
  public $STATUS;
  public $ARTICLE_ID;
}

class Image extends Media{
  public $ID_IMAGE;
}

class Video extends Media{
  public $ID_VIDEO;
}

?>

