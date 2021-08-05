<?php

namespace App\Controller;
use App\Entity\Login;
use App\Entity\Sessions;
use DateTime;
use DateTimeInterface;
use PhpParser\Node\Expr\Cast\Bool_;
use symfony\component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    private $secret_complement_for_hash = "@r123g5h1599#";//responsavel por concatenar com o email do usuario para gerar a rash retornavel
    /**
     * @Route("/login", name="PostLogar", methods={"POST"})
     */
    public function index(): Response
    {
        $reques = ($this->getJsonReceived());
        $camposObrigatorio = ["email", "pass", "appKey"];
        if(!$this->validarCamposObrigatorios($camposObrigatorio, $reques)){
            return $this->json(array("error"=>"Formato de dados incorretos! verifique seu body..."), 400);
        }
        elseif(!$this->validarEmail($reques["email"])){
            return $this->json(array("error"=>"Formato de email é invalido! Verifique..."), 400);
        }
        elseif(!$this->verificarSeEmailERegistrado($reques['email'], $reques['pass'])){
            return $this->json(array("error"=>"este usuario não está cadastrado! Verifique... "), 400);
        }
        elseif(!$this->verificarSeEmailESenhaConfere($reques['email'], $reques['pass'])){
            return $this->json(array("error"=>"A Senha não confere! Verifique... "), 400);
        }
        $nova_secao_do_usuario = $this->gerarSessaoDeUsuario( $reques["appKey"], $reques["email"]);
        if(!$nova_secao_do_usuario){
            return $this->json(array("error"=>"Erro ao criar nova sessão! contate suporte... email:adao.jose123.a.r@gmail.com"),500);
        }
        return $this->json($nova_secao_do_usuario);
    }

    /**
     * @Route("/login", name="updateLogin", methods={"PUT", "PATCH"})
     */
    public function adiarExpiracao(){
        $request = $this->getJsonReceived();
        $camposObrigatorio = ["userKey", "email", "appKey"];
        if(!$this->validarCamposObrigatorios($camposObrigatorio, $request)){
            return $this->json(array("error"=>"Formato de dados incorretos! verifique seu body..."), 400);
        }

        $repository = $this->getDoctrine()->getRepository(Sessions::class);
        $session = $repository->findOneBy([
            "userkey"=>$request["userKey"],
            "appkey"=>$request["appKey"],
            "email"=>$request["email"]
        ]);
        
        if(!$session){
            return $this->json(array("error"=>"Não foram encontrados uma appKey cadastrada para os dados submetidos! Verifique..."), 400);
        }

        $session->setExpiration($this->gerarDataDeExpiracao());
        $session->setUserKey($this->gerarUserKey( $request["email"]) );
        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($session);
        $doctrine->flush();
        return $this->json(
            array(
                "userKey"=>$session->getUserKey(),
                "expiration"=>$session->getExpiration()->format('Y-m-d H:i:s')
            )
        );
    }

    /**
     * @Route("/login/user", name="GetUser", methods={"POST"})
     */
    public function getUser(){
        $camposObrigatorio = ["userKey", "appKey", "email"];
        $request = $this->getJsonReceived();
        if(!$this->validarCamposObrigatorios($camposObrigatorio, $request))
        {
            return $this->json([
                "error"=>"Formato de dados incorretos! verifique seu body..."
            ], 400);
        }
         /**
          * Pega a session do usuario baseado em seua key
          * O objetivo é poder pegar o email do usuario para posteriormente podermos 
          * consutar informações sobre o usuario  
          */
        $repositorySessions = $this->getDoctrine()->getRepository(Sessions::class);
        $session = $repositorySessions->findOneBy([
            "userkey"=>$request["userKey"]
        ]);

        if(!$session){
            return $this->json(array("error"=>"Não foram encontrados uma appKey cadastrada para os dados submetidos! Verifique..."), 400);
        }
        
        $user_email = $session->getEmail();

        $repositoryUser = $this->getDoctrine()->getRepository(Login::class);
        $user = $repositoryUser->findOneBy([
            "email"=>$user_email
        ]);
        return $this->json([
            "email"=>$user->getEmail(),
            "nome"=>$user->getNome(),
            "avatar"=>$user->getAvatar()
        ]);
    }

    /**
     * @Route("/login/cadastro", name="Cadastro de usuario", methods={"POST"})
     */
    public function cadastroDeUsuario()
    {

        ######VERIFICANDO CAMPOS OBRIGATORIO PARA CADATRO DE USUARIO##
        $camposObrigatorio = ["appKey", "email", "senha", "nome"];
        $request = $this->getJsonReceived();
        if (!$this->validarCamposObrigatorios($camposObrigatorio, $request)){
            return $this->json([
                "error"=>"Formato de dados incorretos! verifique seu body..."
            ],400);
        }

        ###VALIDAR SE EMAIL É VALIDO##
        if(!$this->validarEmail($request["email"])){
            return $this->json(array("error"=>"Formato de email é invalido! Verifique..."), 400);
        }

        ##VERIFICAR SE O EMAIL JÁ NÃO ESTÁ REGISTRADO##  
        $repository = $this->getDoctrine()->getRepository(Login::class);
        $email = $repository->findAll(array("email"=>$request["email"]));
        if($email){
            return $this->json(array("error"=>"Este email ja está registrado! Verifique..."), 400);
        }

        ###REGISTRAR NOVO USUARIO#####
        $novoUsuario = new Login();
        $novoUsuario->setEmail($request["email"]);
        $novoUsuario->setNome($request["nome"]);
        $novoUsuario->setSenha($request["senha"]);
        $novoUsuario->setAvatar($request["avatar"]);
        $novoUsuario->setAppKey($request["appKey"]);
        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($novoUsuario);
        $doctrine->flush();
        return $this->json([], 201);
    }
    /**
     * Usado para cadastro de login;
     * A utilização é feita atraves de uma nova instancia da classe LoginControler 
     * @return bool
     * case sucsses @return true;
     * case falied @return false; 
     * 
     */
    public function cadastreNovoLogin(string $email, string $senha){
        $Login = new Login();
        $Login->setEmail($email);
        $Login->setSenha(password_hash($senha, PASSWORD_DEFAULT));
        $Doctrine = $this->getDoctrine()->getManager();
        $Doctrine->persist($Login);
        $Doctrine->flush();

        return true;
        
    }

    private function gerarSessaoDeUsuario(string $appKey, string $userEmail){
        ####VERIFICAR SE O USUARIO JA TEM UMA SESSION CRIADA##
        $repository = $this->getDoctrine()->getRepository(Sessions::class);
        $session_usuario = $repository->findOneBy(["email"=>$userEmail]);
        if(!$session_usuario){
            $session_usuario = new Sessions();
        }
        try{
            
            $userKey = $this->gerarUserKey($userEmail);
            
            $session_usuario->setAppkey($appKey);
            
            $session_usuario->setExpiration( $this->gerarDataDeExpiracao() );
            $session_usuario->setUserkey($userKey);
            $session_usuario->setEmail($userEmail);
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($session_usuario);
            $doctrine->flush();
            return array(
                "userKey"=>$userKey,
                "expiration"=>$session_usuario->getExpiration()->format('Y-m-d H:i:s')
            );

        }catch(\Exception $e){
            // echo 'Caught exception: ',  $e->getMessage(), "\n";
            return false;
        }
    }
    private function gerarDataDeExpiracao(){
        $expirationIncrementada = date('Y-m-d H:i:s', strtotime('+30 days'));
        return new DateTime($expirationIncrementada);
    }
    private function gerarUserKey( string $userEmail)
    {
        return password_hash($userEmail.$this->secret_complement_for_hash, PASSWORD_DEFAULT);
    }

    private function verificarSeEmailERegistrado($email){
        $repository = $this->getDoctrine()->getRepository(Login::class);
        $usuario = $repository->findOneBy(["email"=>$email]);
        return $usuario;
    }
    private function verificarSeEmailESenhaConfere($email, $senha){
        $repository = $this->getDoctrine()->getRepository(Login::class);
        $usuario = $repository->findOneBy(array("email"=>$email, "senha"=>$senha));
        return $usuario;
    }
    private function validarEmail($email){
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function validarCamposObrigatorios(array $camposObrigatorio, array $json)
    {
        foreach($camposObrigatorio as $campoObrigatorio){
            if(
                !array_key_exists($campoObrigatorio, $json)
            ){
                return false;
            }
        }
        return true;
    }
    private function getJsonReceived(){
        // var_dump(json_decode(file_get_contents("php://input")));
        return json_decode(file_get_contents("php://input"), true);
    }
}


