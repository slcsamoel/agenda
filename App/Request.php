<?php 

    namespace App;

    class Request 
    {
        private $request;
        private $class;
        private $params = array();
		private $userLogado;


        public function __construct($req)
        {
            $this->request = $req;
			$this->userLogado = $_SESSION['usuario'];
            $this->load();

        }


        public function load()
		{

			//$newUrl = explode('/', $this->request['url']); // servidor apache

			$newUrl = explode('/', $this->request);
			array_shift($newUrl);

			if(empty($newUrl[0])){
				
				$newUrl[0] = 'login';
			}

			if (isset($newUrl[0])) {
				$this->class = ucfirst($newUrl[0]).'Controller';
				array_shift($newUrl);

				if (isset($newUrl[0])) {
					$this->method = $newUrl[0];
					array_shift($newUrl);

					if (isset($newUrl[0])) {
						$this->params = $newUrl;
					}
				}else{
                    $this->method = 'index';
                }
			}
		}

        public function run()
		{
			if (class_exists('\App\Controllers\\'.$this->class) && method_exists('\App\Controllers\\'.$this->class, $this->method)) {

				try {

					$controll = "\App\Controllers\\".$this->class;

					$response = call_user_func_array(array(new $controll, $this->method), $this->params);

				} catch (\Exception $e) {

					return json_encode(array('data' => $e->getMessage(), 'status' => 'error'));
				}
				
			} else {

				return json_encode(array('data' => 'Operação Inválida', 'status' => 'error'));

			}
		}



    }