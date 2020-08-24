<?php

/**
 * AddressTest class file
 *
 * PHP Version 7.1
 *
 * @category AddressTest
 * @package  AddressTest
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

namespace App\Tests\Entity;

use App\Entity\Address;
use App\Entity\Country;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * AddressTest class
 *
 * The class holding the root AddressTest class definition
 *
 * @category AddressTest
 * @package  AddressTest
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */
class AddressTest extends TestCase
{
    /**
     * Test Address
     *
     * @return mixed
     */
    public function testAddress()
    {
        $address = new Address();
        $country = new Country();
        $user    = new User();

        $address->setStreet('77 rue test')
            ->setCity('Paris')
            ->setDepartment('Paris')
            ->setRegion('Paris')
            ->setZipcode('92000')
            ->setCountry($country)
            ->setUser($user);

        $this->assertEquals($address->getStreet(), '77 rue test');
        $this->assertEquals($address->getCity(), 'Paris');
        $this->assertEquals($address->getDepartment(), 'Paris');
        $this->assertEquals($address->getRegion(), 'Paris');
        $this->assertEquals($address->getZipcode(), '92000');
        $this->assertEquals($address->getCountry(), $country);
        $this->assertEquals($address->getUser(), $user);
    }
}
