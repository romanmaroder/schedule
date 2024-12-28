<?php


namespace core\entities;


readonly class Address
{
    public string $town;
    public string $borough;
    public string $street;
    public string $home;
    public string $apartment;

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