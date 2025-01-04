<?php


namespace core\entities;


readonly class Address
{

    /**
     * @param string|null $town
     * @param string|null $borough
     * @param string|null $street
     * @param string|null $home
     * @param string|null $apartment
     */
    public function __construct(
        public string|null $town,
        public string|null $borough,
        public string|null $street,
        public string|null $home,
        public string|null $apartment
    ) {}


}