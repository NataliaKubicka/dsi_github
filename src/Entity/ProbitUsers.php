<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProbitUsersRepository")
 */
class ProbitUsers
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $surname;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Type(type="numeric", message = "Ta wartość powinna być liczbą")
     * @Assert\NotBlank()
     */
    private $number;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $localization;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return ProbitUsers
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     * @return ProbitUsers
     */
    public function setSurname(string $surname): self
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumber(): ?int
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     * @return ProbitUsers
     */
    public function setNumber(?string $number): self
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocalization(): ?string
    {
        return $this->localization;
    }

    /**
     * @param mixed $localization
     * @return ProbitUsers
     */
    public function setLocalization(string $localization): self
    {
        $this->localization = $localization;
        return $this;
    }
}
