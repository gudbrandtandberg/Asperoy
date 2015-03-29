<?php
/**
 * Created by PhpStorm.
 * User: eivindbakke
 * Date: 2/27/15
 * Time: 7:13 PM
 */

class Event {

    public $id;

    public $title;
    public $details;
    public $start;
    public $end;
    public $creator;
    public $color;

    public function __construct($title, $start, $end, $creator, $color, $details = NULL) {
        $this->title = $title;
        $this->start = $start;
        $this->end = $end;
        $this->creator = $creator;
        $this->color = $color;
        $this->details = $details;
    }

}