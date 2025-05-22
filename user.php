<?php
class User {
    private $id;
    private $email;
    private $password;
    private $role;

    public function __construct($id, $email, $password, $role = 'student') {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function getId() { return $this->id; }
    public function getEmail() { return $this->email; }
    public function getRole() { return $this->role; }
}
?>