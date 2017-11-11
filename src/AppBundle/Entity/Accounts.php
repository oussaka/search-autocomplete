<?php
/**
 * Created by PhpStorm.
 * User: oussaka
 * Date: 05/11/2017
 * Time: 12:54
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="accounts")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AccountsRepository")
 */
class Accounts
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="givenname", type="string", length=255)
     */
    private $givenname;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var integer
     *
     * @ORM\Column(name="gender", type="string", length=1)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="emailaddress", type="string", length=255)
     */
    private $emailaddress;

    /**
     * @var integer
     *
     * @ORM\Column(name="birthday", type="string", length=255)
     */
    private $birthday;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getGivenName(): string
    {
        return $this->givenname;
    }

    /**
     * @param string $givenname
     */
    public function setGivenName(string $givenname)
    {
        $this->givenname = $givenname;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getEmailaddress(): string
    {
        return $this->emailaddress;
    }

    /**
     * @return int
     */
    public function getBirthday(): int
    {
        return $this->birthday;
    }

    /**
     * @return int
     */
    public function getGender(): int
    {
        return $this->gender;
    }

    /**
     * @return array
     */
    public function getNameSuggest(): array
    {
        return array(
            'input' => $this->getGivenName(),
        );
    }

}