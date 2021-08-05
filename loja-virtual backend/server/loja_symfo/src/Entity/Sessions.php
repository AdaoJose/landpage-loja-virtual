<?php

namespace App\Entity;

use App\Repository\SessionsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SessionsRepository::class)
 */
class Sessions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $userkey;

    /**
     * @ORM\Column(type="text")
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     */
    private $appkey;

    /**
     * @ORM\Column(type="datetime")
     */
    private $expiration;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserkey(): ?string
    {
        return $this->userkey;
    }

    public function setUserkey(string $userkey): self
    {
        $this->userkey = $userkey;

        return $this;
    }
    
    public function getEmail(): ?string
    {
        return $this->email;
    }

    

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAppkey(): ?string
    {
        return $this->appkey;
    }

    public function setAppkey(string $appkey): self
    {
        $this->appkey = $appkey;

        return $this;
    }

    public function getExpiration(): ?\DateTimeInterface
    {
        return $this->expiration;
    }

    public function setExpiration(\DateTimeInterface $expiration): self
    {
        $this->expiration = $expiration;

        return $this;
    }
}
