<?php


namespace core\entities;


class Address
{
    public $town;
    public $borough;
    public $street;
    public $home;
    public $apartment;

    /**
     * Address constructor.
     * @param $town
     * @param $borough
     * @param $street
     * @param $home
     * @param $apartment
     */
    public function __construct($town, $borough, $street, $home, $apartment)
    {
        $this->town = $town;
        $this->borough = $borough;
        $this->street = $street;
        $this->home = $home;
        $this->apartment = $apartment;
    }


}