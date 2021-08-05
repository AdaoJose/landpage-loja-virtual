<?php

namespace App\Entity;

use App\Repository\LoginRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LoginRepository::class)
 */
class Login
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $senha;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nome;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $avatar;
    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private $appKey;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSenha(): ?string
    {
        return $this->senha;
    }

    public function setSenha(string $senha): self
    {
        $this->senha = $senha;

        return $this;
    }

    public function getNome(){
        return $this->nome;
    }
    public function setNome(string $nome): self
    {
        $this->nome = $nome;
        return $this;
    }
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }
    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;
        return $this;
    }

    public function getAppKey(): ?string
    {
        return $this->appKey;
    }
    public function setAppKey(string $appKey): self
    {
        $this->appKey = $appKey;
        return $this;
    }
}
