<?php 

    namespace App\Controllers;
    use App\Models\User;
    use App\Helpers\RenderHTML;

    class LoginController
    {

        private static $key = 'a0p5i3m';
        public $view;

        public function __construct(){
            $this->view = new RenderHTML();

        }



        public function index(){
            
          echo $this->view->renderHtml('home.php', ['title' => 'Pagina Home']);

       } 


        public function logar(){

            if (isset($_POST['email']) && isset($_POST['senha'])){

                    $verification = User::verificationUserExist($_POST['email']);
                
                    if($verification != false ){
                        
                        if($verification[0]['senha'] == md5($_POST['senha'])){

                            $user = User::logar($_POST['email'] , $_POST['senha']);
                            $token = self::createToken($user['email'] , $user['name']);


                            $_SESSION['usuario'] = $user;

                            echo $this->view->renderHtml('painel.php', ['user' =>  $user]);
                        }else{
                            echo $this->view->renderHtml('home.php', ['error' => 'Senha Errada!']);   
                        }
                          
                    }else{

                        echo $this->view->renderHtml('home.php', ['error' => 'Usuario não existe!']); 
                    }         

            }

        }


        private static function createToken($email , $name){
            //Header Token
              $header = [
                'typ' => 'JWT',
                'alg' => 'HS256'
            ];

            //Payload - Content
            $payload = [
                'name' => $name,
                'email' => $email,
            ];

            //JSON
            $header = json_encode($header);
            $payload = json_encode($payload);

            //Base 64
            $header = self::base64UrlEncode($header);
            $payload = self::base64UrlEncode($payload);

            //Sign
            $sign = hash_hmac('sha256', $header . "." . $payload, self::$key, true);
            $sign = self::base64UrlEncode($sign);

            //Token
            $token = $header . '.' . $payload . '.' . $sign;

            return $token;

        }

        private static function base64UrlEncode($data)
        {
            // First of all you should encode $data to Base64 string
            $b64 = base64_encode($data);

            // Make sure you get a valid result, otherwise, return FALSE, as the base64_encode() function do
            if ($b64 === false) {
                return false;
            }

            // Convert Base64 to Base64URL by replacing “+” with “-” and “/” with “_”
            $url = strtr($b64, '+/', '-_');

            // Remove padding character from the end of line and return the Base64URL result
            return rtrim($url, '=');
        }

        public static function checkAuth()
        {
            $http_header = apache_request_headers();

            if (isset($http_header['Authorization']) && $http_header['Authorization'] != null) {
                $bearer = explode (' ', $http_header['Authorization']);
                //$bearer[0] = 'bearer';
                //$bearer[1] = 'token jwt';

                $token = explode('.', $bearer[1]);
                $header = $token[0];
                $payload = $token[1];
                $sign = $token[2];

                //Conferir Assinatura
                $valid = hash_hmac('sha256', $header . "." . $payload, self::$key, true);
                $valid = self::base64UrlEncode($valid);

                if ($sign === $valid) {
                    return true;
                }
            }

            return false;
        }

    }