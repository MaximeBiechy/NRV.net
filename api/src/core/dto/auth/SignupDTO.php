<?php
  namespace toubeelib\core\dto\auth;

  class SignupDTO extends DTO{
    private string $name;
    private string $surname;
    private string $address;
    private string $phone;

    public function __construct(string $id, string $surname, int $address, string $phone){
      $this->name = $id;
      $this->surname = $surname;
      $this->address = $address;
      $this->phone = $phone;
    }
  }
?>
