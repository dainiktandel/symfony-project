<?php

namespace App\Services;

class Notification{
     private $email;

    public function __construct($email, FileUploder $fileuploder){
      dump($fileuploder);
      die();
      $this->email = $email;
    }

    public function sendNotification(){

    }

}
