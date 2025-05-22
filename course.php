<?php
class Course {
    private $id;
    private $title;
    private $description;
    private $price;
    private $category;
    private $image;

    public function __construct($id, $title, $description, $price, $category, $image) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->category = $category;
        $this->image = $image;
    }

    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getDescription() { return $this->description; }
    public function getPrice() { return $this->price; }
    public function getCategory() { return $this->category; }
    public function getImage() { return $this->image; }
}
?>
