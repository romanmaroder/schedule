<?php


namespace core\entities;


readonly class Address
{
    public null|string $town;
    public null|string $borough;
    public null|string $street;
    public null|string $home;
    public null|string $apartment;

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