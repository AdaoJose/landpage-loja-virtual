<?php

namespace App\Controller;

use App\Entity\Produtos;
use DateTimeZone;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Str;

class ProdutoController extends AbstractController
{
    /**
     * @Route("/", name="get_produto", methods={"GET"})
     */
    public function index(): Response
    {
        $produtos =  $this->getDoctrine()->getRepository(Produtos::class)->findAll();
        return $this->json([
            'data' => $produtos
        ]);
    }

    /**
     * @Route("/", name="create_product", methods={"POST"})
     */

     public function create(Request $Request){
            $data = $this->getJsonReceived();
            var_dump(json_encode($data));
            $produto = new Produtos();
            // var_dump($data);
            echo "\n \n \n";
            $produto->setItem($data);
            $produto->setDate( new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));
            $produto->setCategoria(  $data ["categoria"] );
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($produto);
            $doctrine->flush();
            return $this->json($data); 
     }

     /**
      * @Route("/{idDoProduto}", name="show", methods={"GET"})
      */

      public function show($idDoProduto){
            $produto = $this->getDoctrine()->getRepository(Produtos::class)->find($idDoProduto);
            return $this->json($produto);
      }

      /**
       * @Route("/idDoProduto", name="delete", methods={"DELETE"})
       */

       public function delete($idDoProduto){

       }

       /**
        * @Route("/{idDoProduto}", name="update", methods={"PUT", "PATCH"})
        */
        public function update($idDoProduto){
            $produto = $this->getDoctrine()->getRepository(Produtos::class)->find($idDoProduto);
            echo array_key_exists("nome", $this->getJsonReceived());
            $produtoDesatualizado  = $produto->getItem();
            if(array_key_exists("nome", $this->getJsonReceived())){
                $produtoDesatualizado["nome"] = $this->getJsonReceived()['nome'];
            }
            if(array_key_exists("categoria", $this->getJsonReceived())){
                $produtoDesatualizado["categoria"] = $this->getJsonReceived()['categoria'];
                $produto->setCategoria($this->getJsonReceived()['categoria']);
            }
            if(array_key_exists("genero", $this->getJsonReceived())){
                $produtoDesatualizado["genero"] = $this->getJsonReceived()['genero'];
            }
            if(array_key_exists("tamanho", $this->getJsonReceived())){
                $produtoDesatualizado["tamanho"] = $this->getJsonReceived()['tamanho'];
            }
            if(array_key_exists("quantidade_em_estoque", $this->getJsonReceived())){
                $produtoDesatualizado["quantidade_em_estoque"] = $this->getJsonReceived()['quantidade_em_estoque'];
            }
            if(array_key_exists("cor", $this->getJsonReceived())){
                $produtoDesatualizado["cor"] = $this->getJsonReceived()['cor'];
            }
            if(array_key_exists("link_para_outras_cores", $this->getJsonReceived())){
                $produtoDesatualizado["link_para_outras_cores"] = $this->getJsonReceived()['link_para_outras_cores'];
            }
            if(array_key_exists("imagens", $this->getJsonReceived())){
                $produtoDesatualizado["imagens"] = $this->getJsonReceived()['imagens'];
            }
            var_dump($produtoDesatualizado);
            $produto->setItem($produtoDesatualizado);
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($produto);
            $doctrine->flush();
            return $this->json([]);
        }

        private function getJsonReceived(){
            return json_decode(file_get_contents("php://input"), true);
        }
}
