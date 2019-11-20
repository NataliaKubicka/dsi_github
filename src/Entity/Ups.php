<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UpsRepository")
 */
class Ups
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $address;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $localization;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $assignment;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $ip;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $model;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $sn;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $info;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     * @return Ups
     */
    public function setCity(?string $city): self
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     * @return Ups
     */
    public function setAddress(?string $address): self
    {
        $this->address = $address;
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
     * @return Ups
     */
    public function setLocalization(?string $localization): self
    {
        $this->localization = $localization;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAssignment(): ?string
    {
        return $this->assignment;
    }

    /**
     * @param mixed $assignment
     * @return Ups
     */
    public function setAssignment(?string $assignment): self
    {
        $this->assignment = $assignment;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     * @return Ups
     */
    public function setIp(?string $ip): self
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getModel(): ?string
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     * @return Ups
     */
    public function setModel(?string $model): self
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSn(): ?string
    {
        return $this->sn;
    }

    /**
     * @param mixed $sn
     * @return Ups
     */
    public function setSn(?string $sn): self
    {
        $this->sn = $sn;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInfo(): ?string
    {
        return $this->info;
    }

    /**
     * @param mixed $info
     * @return Ups
     */
    public function setInfo(?string $info): self
    {
        $this->info = $info;
        return $this;
    }

}
