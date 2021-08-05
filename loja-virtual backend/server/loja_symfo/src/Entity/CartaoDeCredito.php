<?php

namespace App\Entity;

use App\Repository\CartaoDeCreditoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CartaoDeCreditoRepository::class)
 */
class CartaoDeCredito
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
    private $numero;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomeDoTitular;

    /**
     * @ORM\Column(type="date")
     */
    private $validade;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cpfDoTitular;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $toquenDoCartao;

    /**
     * @ORM\Column(type="text")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codigo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bandeira;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getNomeDoTitular(): ?string
    {
        return $this->nomeDoTitular;
    }

    public function setNomeDoTitular(string $nomeDoTitular): self
    {
        $this->nomeDoTitular = $nomeDoTitular;

        return $this;
    }

    public function getValidade(): ?\DateTimeInterface
    {
        return $this->validade;
    }

    public function setValidade(\DateTimeInterface $validade): self
    {
        $this->validade = $validade;

        return $this;
    }

    public function getCpfDoTitular(): ?string
    {
        return $this->cpfDoTitular;
    }

    public function setCpfDoTitular(string $cpfDoTitular): self
    {
        $this->cpfDoTitular = $cpfDoTitular;

        return $this;
    }

    public function getToquenDoCartao(): ?string
    {
        return $this->toquenDoCartao;
    }

    public function setToquenDoCartao(?string $toquenDoCartao): self
    {
        $this->toquenDoCartao = $toquenDoCartao;

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

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getBandeira(): ?string
    {
        return $this->bandeira;
    }

    public function setBandeira(string $bandeira): self
    {
        $this->bandeira = $bandeira;

        return $this;
    }
}
