<?php

namespace App\Controller;

use App\Entity\CartaoDeCredito;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PagamentoController extends AbstractController
{
    /**função que aceita pagamneto via cartão de credito */
    /**
     * @Route("/pagamento/cartao", name="pagamento_cartao", methods={"POST"})
     */
    public function CartaoDeCredito(/**\App\Controller\CartaoController $cartaoController */)
    {
        $manager  = $this->getDoctrine()->getManager();
        $cartao = $manager->getRepository(CartaoDeCredito::class)->findOneBy(array('toquenDoCartao' => 'teste'));
         
        var_dump($cartao);
        
        // $cartaoController->comprar();
        switch(\App\Controller\RequestController::getRequest()['tipo'])
        {
            case 'cartaoDeCredito':
                if(! \App\Controller\RequestController::paramRequestExists(['toquen', 'produtos'])){
                    return $this->json(['status' => 'error', 'error'=>'Parametros inconpleto! verifique...'], 500);
                }
                break;
        }
        $cartao  = new \App\Controller\CartaoController();
        $cartao->comprar(\App\Controller\RequestController::getRequest()['produtos']);
        return $this->json(array('status' => \App\Controller\RequestController::getRequest()));
    }
}
