<?php
class Review {
    private $id;
    private $userName;
    private $courseTitle;
    private $rating;
    private $message;

    public function __construct($id, $userName, $courseTitle, $rating, $message) {
        $this->id = $id;
        $this->userName = $userName;
        $this->courseTitle = $courseTitle;
        $this->rating = $rating;
        $this->message = $message;
    }

    public function getId() { return $this->id; }
    public function getUserName() { return $this->userName; }
    public function getCourseTitle() { return $this->courseTitle; }
    public function getRating() { return $this->rating; }
    public function getMessage() { return $this->message; }
}
?>