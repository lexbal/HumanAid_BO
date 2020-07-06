<?php

/**
 * CountryTest class file
 *
 * PHP Version 7.1
 *
 * @category CountryTest
 * @package  CountryTest
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
 * CountryTest class
 *
 * The class holding the root CountryTest class definition
 *
 * @category CountryTest
 * @package  CountryTest
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */
class CountryTest extends TestCase
{
    /**
     * Test Address
     *
     * @return mixed
     */
    public function testCountry()
    {
        $country = new Country();
        $address = new Address();

        $country->setCode("fr")
            ->setLabel("France")
            ->addAddress($address);

        $this->assertEquals($country->getCode(), 'fr');
        $this->assertEquals($country->getLabel(), 'France');

        foreach ($country->getAddresses() as $addr) {
            $this->assertEquals($address, $addr);
        }

        $country->removeAddress($address);
        $this->assertEmpty($country->getAddresses());
    }
}
