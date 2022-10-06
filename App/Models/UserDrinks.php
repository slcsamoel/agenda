<?php

    namespace App\Models;

    class UserDrinks
    {
        private static $table = 'user_drinks';


        public static function getDrinksUser($user_id){
            $connPdo = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME , DBUSER, DBPASS);

            $sql = 'SELECT * FROM '.self::$table.' WHERE user_id = :user_id';
            $stmt = $connPdo->prepare($sql);
            $stmt->bindValue(':user_id', $user_id);
            $stmt->execute();

            if($stmt->rowCount() > 0){

                return $stmt->fetch(\PDO::FETCH_ASSOC); // não duplicar as informações 

            }else{

                return array();
            }

        }

        public static function setDrinksUser($user_id){
            $connPdo = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME , DBUSER, DBPASS);

            $sql = 'INSERT INTO '.self::$table.' (user_id, drink) VALUES (:user_id , :drink)';
            $stmt = $connPdo->prepare($sql);
            $stmt->bindValue(':user_id', $user_id);
            $stmt->bindValue(':drink', 'café');
            $stmt->execute();


            $sql = 'SELECT * FROM '.self::$table.' WHERE user_id = :user_id';
            $stmt = $connPdo->prepare($sql);
            $stmt->bindValue(':user_id', $user_id);
            $stmt->execute();

            if($stmt->rowCount() > 0){

                return true;

            }else{

                throw new \Exception("Falha ao inserir o drink!");
            }

        }

    }