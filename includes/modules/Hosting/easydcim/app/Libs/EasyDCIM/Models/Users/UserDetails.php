<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Users;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Serializer;

/**
 * Description of CreateOrder
 *
 * @author Mateusz Pawłowski <mateusz.pa@modulesgarden.com>
 */
class UserDetails extends Serializer
{

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $firstname;

    /**
     * @var string
     */
    protected $lastname;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $password_confirmation;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $address1;

    /**
     * @var string
     */
    protected $address2;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var string
     */
    protected $country_code;

    /**
     * @var integer
     */
    protected $postcode;

    /*
     * User username
     * 
     * @params string $username
     * @return object $this;
     * 
     */

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /*
     * User first name
     * 
     * @params string $firstname
     * @return object $this;
     * 
     */

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /*
     * User last name
     * 
     * @params string $lastname
     * @return object $this;
     * 
     */

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    /*
     * User email
     * 
     * @params string $username
     * @return object $this;
     * 
     */

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /*
     * User Password
     * 
     * @params string $password
     * @return object $this;
     * 
     */

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /*
     * User confirm password
     * 
     * @params string $passwordConfirmation
     * @return object $this;
     * 
     */

    public function setPasswordConfirmation($passwordConfirmation)
    {
        $this->password_confirmation = $passwordConfirmation;
        return $this;
    }

    /*
     * User city
     * 
     * @params string $city
     * @return object $this;
     * 
     */

    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /*
     * User address
     * 
     * @params string $address1
     * @return object $this;
     * 
     */

    public function setAddress1($address1)
    {
        $this->address1 = $address1;
        return $this;
    }

    /*
     * User address
     * 
     * @params string $address2
     * @return object $this;
     * 
     */

    public function setAddress2($address2)
    {
        $this->address2 = $address2;
        return $this;
    }

    /*
     * User state
     * 
     * @params string $state
     * @return object $this;
     * 
     */

    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /*
     * User country code
     * 
     * @params string $countryCode
     * @return object $this;
     * 
     */

    public function setCountryCode($countryCode)
    {
        $this->country_code = $countryCode;
        return $this;
    }

    /*
     * User post code
     * 
     * @params string $postcode
     * @return object $this;
     * 
     */

    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
        return $this;
    }

}
