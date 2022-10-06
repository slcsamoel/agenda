<?php 

    namespace App\Controllers;
    use App\Models\User;

    class UserController
    {

        public function getUser($id)
        {
            if (LoginController::checkAuth()) {
				$user = User::find($id);
                
                return[
                    'user' => $user,
                ];
			}
			
			throw new \Exception('Não autenticado');
            
        }

        public function getUsers()
        {
            if (LoginController::checkAuth()) {
				$users = User::all();

                return[
                    'users' => $users
                ];
			}
			
			throw new \Exception('Não autenticado');
        }

        public function create()
        {
            if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])){

                $verification = User::verificationUserExist($_POST['email']);

                if($verification != false ){
                    throw new \Exception('Esse usuario já existe!');
                }


                $data = $_POST;
                return  User::create($data);

            }

            throw new \Exception('dados invalidos');

        }

        public function update($id)
        {
            if (LoginController::checkAuth()) {

                if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])){

                    $data = $_POST;
                    return  User::update($id , $data);
    
                }
            
			}
			
			throw new \Exception('Não autenticado');

        }

        public function delete($id)
        {
            if (LoginController::checkAuth()) {
				return User::delete($id);
			}
			
			throw new \Exception('Não autenticado');


        }



    }