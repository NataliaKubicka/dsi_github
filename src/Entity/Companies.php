<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompaniesRepository")
 * @UniqueEntity(fields="idCompany", message="Firma o podanym ID już istnieje")
 * @ORM\HasLifecycleCallbacks()
 */
class Companies
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $status;

    /**
     * @ORM\Column(type="integer", nullable=true, unique=true)
     */
    private $idCompany;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $adIdentifier;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank()
     * @Assert\Length(min="10", minMessage="Pole NIP musi zawierać 10 znaków")
     * @Assert\Length(max="10", minMessage="Pole NIP musi zawierać 10 znaków")
     */
    private $nip;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $comments;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return Companies
     */
    public function setStatus(?int $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdCompany(): ?int
    {
        return $this->idCompany;
    }

    /**
     * @param mixed $idCompany
     * @return Companies
     */
    public function setIdCompany(int $idCompany): self
    {
        $this->idCompany = $idCompany;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdIdentifier(): ?string
    {
        return $this->adIdentifier;
    }

    /**
     * @param mixed $adIdentifier
     * @return Companies
     */
    public function setAdIdentifier(?string $adIdentifier): self
    {
        $this->adIdentifier = $adIdentifier;
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
     * @return Companies
     */
    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNip(): ?string
    {
        return $this->nip;
    }

    /**
     * @param mixed $nip
     * @return Companies
     */
    public function setNip(?string $nip): self
    {
        $this->nip = $nip;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComments(): ?string
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     * @return Companies
     */
    public function setComments(?string $comments): self
    {
        $this->comments = $comments;
        return $this;
    }

}
