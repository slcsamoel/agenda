<?php 

    namespace App\Controllers;
    use App\Models\UserDrinks;
    use App\Models\User;

    class DrinkController
    {


        public function setDrink($id)
        {

            if (LoginController::checkAuth()) {
				
                if(UserDrinks::setDrinksUser($id)){

                    $user = User::find($id);
                
                    return[
                        'user' => $user,
                    ];
                }
			}
			
			throw new \Exception('Não autenticado');

        }


    }