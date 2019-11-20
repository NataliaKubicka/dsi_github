<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 * @UniqueEntity(fields="email", groups={"addUser", "editUser"}, message="Ten adres email jest już zarejestrowany")
 * @UniqueEntity(fields="username", groups={"addUser", "editUser"}, message="Ta nazwa użytkownika jest już używana")
 * @ORM\HasLifecycleCallbacks()
 */
class Users implements UserInterface, Serializable {


    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(groups={"addUser", "editUser"}, min="3", max="50")
     * @Assert\NotBlank(groups={"addUser", "editUser"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(groups={"addUser", "editUser"}, min="3", max="50")
     * @Assert\NotBlank(groups={"addUser", "editUser"})
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=6, unique=true)
     * @Assert\Length(groups={"addUser"}, min="6", max="6")
     * @Assert\NotBlank(groups={"addUser", "editUser"})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Length(groups={"addUser", "editUser"}, min="6", max="255")
     * @Assert\Email(groups={"addUser", "editUser", "recoveryPassword"})
     * @Assert\NotBlank(groups={"addUser", "editUser", "recoveryPassword"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @Assert\Regex(
     *     groups={"setNewPassword"},
     *     pattern="/(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,70}/",
     *     match=true,
     *     message="Hasło musi składać się z przynajmniej 8 znaków, zawierać przynajmniej jedną małą i dużą literę, znak specjalny oraz cyfrę"
     * )
     * @Assert\NotBlank(groups={"setNewPassword"})
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $passwordRequestToken;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="bool")
     * @Assert\NotBlank(groups={"addUser", "editUser"})
     */
    private $isActive;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Role")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(groups={"addUser", "editUser"})
     */
    private $userRole;

    public function __construct() {
        $this->userRoles = new ArrayCollection();
    }

    public function getRoles()
    {
        return [$this->getUserRole()->getName()];
    }

    public function getSalt() {
        return null;
    }

    public function eraseCredentials() {
        return null;
    }

    public function serialize() {
        return serialize([
            $this->id,
            $this->username,
            $this->password
        ]);
    }

    public function unserialize($serialized) {
        list($this->id,
            $this->username,
            $this->password) = unserialize($serialized);
    }

    public function getId(): ?int {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName(): ?string {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Users
     */
    public function setName(?string $name): self {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSurname(): ?string {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     * @return Users
     */
    public function setSurname(?string $surname): self {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername(): ?string {
        return $this->username;
    }

    /**
     * @param mixed $username
     * @return Users
     */
    public function setUsername(?string $username): self {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail(): ?string {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Users
     */
    public function setEmail(?string $email): self {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword(): ?string {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return Users
     */
    public function setPassword(string $password): self {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword): void {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return null|string
     */
    public function getPasswordRequestToken(): ?string {
        return $this->passwordRequestToken;
    }

    public function setPasswordRequestToken(?string $passwordRequestToken) {
        $this->passwordRequestToken = $passwordRequestToken;
    }

    /**
     * @return boolean
     */
    public function getIsActive() :?bool {
        return $this->isActive;
    }

    public function setIsActive($active): void {
        $this->isActive = $active;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAt(): self
    {
        $this->createdAt = new \DateTime();

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdatedAt(): self
    {
        $this->updatedAt = new \DateTime();

        return $this;
    }

    public function updateModifiedDatetime() {
        $this->setUpdatedAt();
    }

    public function getUserRole(): ?Role
    {
        return $this->userRole;
    }

    public function setUserRole(?Role $userRole): self
    {
        $this->userRole = $userRole;

        return $this;
    }
}
