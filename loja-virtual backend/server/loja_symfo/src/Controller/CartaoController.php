<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartaoController extends AbstractController
{
    private $numero;
    private $codigo;
    private $validade;
    private $cpfTitular;
    private $nomeTitular;
    private $bandeira;
    private $toquenDoCartao;
    
    /**faça um get e um set para toquenDoCartao */
    public function setToquenDoCartao($toquenDoCartao): self
    {
        $this->toquenDoCartao = $toquenDoCartao;
        return $this;
    }
    public function getToquenDoCartao()
    {
        return $this->toquenDoCartao;
    }

    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CartaoController.php',
        ]);
    }
    /**faça um get e um set para bandeira */
    public function setBandeira(string $bandeira): self
    {
        $bandeirasAceitas = ['visa', 'mastercard', 'amex'];
        if (in_array($bandeira, $bandeirasAceitas)) {
            $this->bandeira = $bandeira;
        } else {
            throw new \Exception('Esta bandeira não está no range de bandeiras aceitas!');
        }
        return $this;
    }
    public function getBandeira(): string
    {
        return $this->bandeira;
    }
    /** faça um get e um set para cada atributo de minha classe */
    public function setNumero($numero): self
    {
        $this->numero = $numero;
        return $this;
    }
    public function getNumero()
    {
        return $this->numero;
    }
    public function setCodigo($codigo): self
    {
        $this->codigo = $codigo;
        return $this;
    }
    public function getCodigo()
    {
        return $this->codigo;
    }
    public function setValidade($validade): self
    {
        $this->validade = $validade;
        return $this;
    }
    public function getValidade()
    {
        return $this->validade;
    }
    public function setCpfTitular($cpfTitular): self
    {
        $this->cpfTitular = $cpfTitular;
        return $this;
    }
    public function getCpfTitular()
    {
        return $this->cpfTitular;
    }
    public function setNomeTitular($nomeTitular): self
    {
        $this->nomeTitular = $nomeTitular;
        return $this;
    }
    public function getNomeTitular()
    {
        return $this->nomeTitular;
    }
    /**validar se atributos da classe não estão vazio */
    public function validar(): bool
    {
        if (empty($this->numero) || empty($this->codigo) || empty($this->validade) || empty($this->cpfTitular) || empty($this->nomeTitular) || empty($this->bandeira) || empty($this->toquenDoCartao)) {
            return false;
        }
        return true;
    }
    
    /**faça uma função que cadastre um cartão no banco de dados */
    public function cadastrar(){
        if($this->validar()){   
            $cartao = new \App\Entity\CartaoDeCredito();
            $cartao->setNumero($this->numero);
            $cartao->setCodigo($this->codigo);
            $cartao->setValidade($this->validade);
            $cartao->setcpfDoTitular($this->cpfTitular);
            $cartao->setNomeDoTitular($this->nomeTitular);
            $Doctrine = $this->getDoctrine()->getManager();
            $Doctrine->persist($cartao);
            $Doctrine->flush();
            return true;
        }else{
            return false;
        }
    }

    /**faça uma função que busque um cartão no banco de dados */
    public function buscar(int $id): bool
    {
        $Doctrine = $this->getDoctrine()->getManager();
        $cartao = $Doctrine->getRepository('App:CartaoDeCredito')->find($id);
        if($cartao){
            $this->setNumero($cartao->getNumero());
            $this->setCodigo($cartao->getCodigo());
            $this->setValidade($cartao->getValidade());
            $this->setCpfTitular($cartao->getcpfDoTitular());
            $this->setNomeTitular($cartao->getNomeDoTitular());
            return true;
        }else{
            return false;
        }
    }
    /**faça uma função que atualize um cartão no banco de dados */
    public function atualizar(int $id): bool
    {
        $Doctrine = $this->getDoctrine()->getManager();
        $cartao = $Doctrine->getRepository('App:CartaoDeCredito')->find($id);
        if($cartao){
            $cartao->setNumero($this->numero);
            $cartao->setCodigo($this->codigo);
            $cartao->setValidade($this->validade);
            $cartao->setcpfDoTitular($this->cpfTitular);
            $cartao->setNomeDoTitular($this->nomeTitular);
            $Doctrine->persist($cartao);
            $Doctrine->flush();
            return true;
        }else{
            return false;
        }
    }
    /**faça uma função que delete um cartão no banco de dados */
    public function deletar(int $id): bool
    {
        $Doctrine = $this->getDoctrine()->getManager();
        $cartao = $Doctrine->getRepository('App:CartaoDeCredito')->find($id);
        if($cartao){
            $Doctrine->remove($cartao);
            $Doctrine->flush();
            return true;
        }else{
            return false;
        }
    }
    /**faça uma função chamada comprar que retorne um boleano */
    public function comprar($produtosRequest): bool
    {
        var_dump($produtosRequest);
        return true;
    }
}
