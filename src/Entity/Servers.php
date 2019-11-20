<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServersRepository")
 */
class Servers
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     * @Assert\Length(max="15", minMessage="Pole Adres IP może zawierać maksymalnie 15 znaków")
     * @Assert\NotBlank()
     */
    private $ip;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $localization;

    /**
     * @ORM\Column(type="string", length=200)
     *
     * @Assert\NotBlank()
     */
    private $esxi;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $ups;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url(message = "Wartość '{{ value }}' nie jest poprawnym adresem url")
     */
    private $printerUrl;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $serverGroup;

    /**
     * @ORM\Column(type="string")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $changeStatusDate;


    public function getId(): ?int
    {
        return $this->id;
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
     * @return Servers
     */
    public function setIp(?string $ip): self
    {
        $this->ip = $ip;
        return $this;
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
     * @return Servers
     */
    public function setName(?string $name): self
    {
        $this->name = $name;
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
     * @return Servers
     */
    public function setLocalization(?string $localization): self
    {
        $this->localization = $localization;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEsxi(): ?string
    {
        return $this->esxi;
    }

    /**
     * @param mixed $esxi
     * @return Servers
     */
    public function setEsxi(?string $esxi): self
    {
        $this->esxi = $esxi;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUps(): ?string
    {
        return $this->ups;
    }

    /**
     * @param mixed $ups
     * @return Servers
     */
    public function setUps(string $ups): self
    {
        $this->ups = $ups;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrinterUrl(): ?string
    {
        return $this->printerUrl;
    }

    /**
     * @param mixed $printerUrl
     * @return Servers
     */
    public function setPrinterUrl(string $printerUrl): self
    {
        $this->printerUrl = $printerUrl;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getServerGroup(): ?int
    {
        return $this->serverGroup;
    }

    /**
     * @param mixed $serverGroup
     * @return Servers
     */
    public function setServerGroup(?int $serverGroup): self
    {
        $this->serverGroup = $serverGroup;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {

        return $this->status;
    }

    /**
     * @param mixed $status
     * @return Servers
     */
    public function setStatus($status)
    {
        $this->setChangeStatusDate(new \DateTime());
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getChangeStatusDate()
    {
        return $this->changeStatusDate;
    }

    /**
     * @param mixed $changeStatusDate
     * @return Servers
     */
    public function setChangeStatusDate($changeStatusDate)
    {
        $this->changeStatusDate = $changeStatusDate;
        return $this;
    }

}
