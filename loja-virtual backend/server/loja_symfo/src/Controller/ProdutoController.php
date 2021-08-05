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
    public $cors = ["Access-Control-Allow-Origin"=>"*", "Access-Control-Allow-Headers"=>"*", "Access-Control-Allow-Methods"=>"*","Content-Type"=>"application/json"];
    /**
     * @Route("/", name="get_produto", methods={"GET"})
     */
    public function index(): Response
    {
        $produtos =  $this->getDoctrine()->getRepository(Produtos::class)->findAll();
        return $this->json([
            'data' => $produtos
            

        ], 200, $this->cors);
    }

    /**
     * @Route("/", name="create_product", methods={"POST"})
     */

     public function create(Request $Request){
            $data = $this->getJsonReceived();
            //redimensionando imagem 
            $data["imagens"] = $this->redimensionamentoDeImagem($data["imagens"]);
            $produto = new Produtos();
            // var_dump($data);
            echo "\n \n \n";
            $produto->setItem($data);
            $produto->setDate( new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));
            $produto->setCategoria(  $data ["categoria"] );
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($produto);
            $doctrine->flush();
            return $this->json($data, Response::HTTP_OK, array('Access-Control-Allow-Origin'=> '*'));
            // return $this->json([]);
     }

     /**
      * @Route("/{idDoProduto}", name="show", methods={"GET"})
      */

      public function show($idDoProduto){
            $produto = $this->getDoctrine()->getRepository(Produtos::class)->find($idDoProduto);
            return $this->json($produto);
      }

      /**
       * @Route("/idDoProduto", name="deleteProduto", methods={"DELETE"})
       */

       public function delete($idDoProduto){

       }

       /**
        * @Route("/{idDoProduto}", name="updateProduto", methods={"PUT", "PATCH"})
        */
        public function update($idDoProduto){
            $produto = $this->getDoctrine()->getRepository(Produtos::class)->find($idDoProduto);
            // echo array_key_exists("nome", $this->getJsonReceived());
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
            // var_dump(json_decode(file_get_contents("php://input")));
            return json_decode(file_get_contents("php://input"), true);
        }
        private function redimensionamentoDeImagem(array $arrayImagens): ?array
        {
            
            $pathImage = "/server/imagens";
            $imagensRedimensionadas = [];
            foreach($arrayImagens as $imagem){
                $imagem = substr($imagem["url"], strpos($imagem['url'], ',')+1);
                $imagemBinario = base64_decode($imagem);
                $nomeTemporario = tempnam(sys_get_temp_dir(), 'base64_decode_');
                $file = fopen($nomeTemporario, 'w');
                fwrite($file, $imagemBinario);
                fclose($file);
                $imagemBinario = null;

                $img = imagecreatefromjpeg($nomeTemporario);
                $originalWidth  = imageSX($img);
                $originalHeight = imageSY($img);

                $newWidth = 250;
                $newHeight = 250;
                if($originalWidth > $originalHeight)
                {
                    $widthRatio = $newWidth;
                    $heightRatio = $originalHeight*($newHeight / $originalWidth);
                }

                if($originalWidth < $originalHeight)
                {
                    $widthRatio = $originalWidth*($newWidth / $originalHeight);
                    $heightRatio = $newHeight;
                }

                if($originalWidth == $originalHeight)
                {
                    $widthRatio = $newWidth;
                    $heightRatio = $newHeight;
                }
                
                $resizedImg = imagecreatetruecolor($widthRatio, $heightRatio);
                imagecopyresampled($resizedImg, $img, 0, 0, 0, 0, $widthRatio, $heightRatio, $originalWidth, $originalHeight);
                imagejpeg($resizedImg, $nomeTemporario);
                $imageBase64 = base64_encode(file_get_contents($nomeTemporario));
                array_push($imagensRedimensionadas, array('url'=>"data:image/jpeg;base64,".$imageBase64));
                file_put_contents($pathImage."imagebase64.img", $imageBase64);
            }
            return $imagensRedimensionadas;
        }
}
