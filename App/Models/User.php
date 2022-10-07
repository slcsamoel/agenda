<?php

    namespace App\Models;
    
    class User
    {
        private static $table = 'usuarios';


        public static function find($id){
            $connPdo = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME , DBUSER, DBPASS);

            $sql = 'SELECT U.* , (SELECT COUNT(D.id) FROM user_drinks AS D WHERE D.user_id = U.id) AS drinkCounter  FROM '.self::$table.' AS  U  WHERE id= :id';
            $stmt = $connPdo->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            if($stmt->rowCount() > 0){

                return $stmt->fetch(\PDO::FETCH_ASSOC); // não duplicar as informações 

            }else{

                throw new \Exception("Nenhum usuario encontrado ");
            }

        }

        public static function all(){
            $connPdo = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME , DBUSER, DBPASS);

            $sql = 'SELECT U.* , (SELECT COUNT(D.id) FROM user_drinks AS D WHERE D.user_id = U.id) AS drinkCounter  FROM '.self::$table.' AS  U';
            $stmt = $connPdo->prepare($sql);
            $stmt->execute();

            if($stmt->rowCount() > 0){

                return $stmt->fetchAll(\PDO::FETCH_ASSOC); 

            }else{

                throw new \Exception("Nenhum usuario encontrado ");
            }

        }

        public static function logar($email, $senha){

        
                $connPdo = new \PDO(DBDRIVE.':host='.DBHOST.';dbname='.DBNAME.';port='.DBPORT, DBUSER, DBPASS);

                $senha = md5($senha);
        
                $sql = 'SELECT U.* FROM '.self::$table.' AS  U WHERE email= :email AND senha= :senha';
                $stmt = $connPdo->prepare($sql);
                $stmt->bindValue(':email', $email);
                $stmt->bindValue(':senha', strval($senha));
                $stmt->execute();
                
                if($stmt->rowCount() > 0){
    
                    return $stmt->fetch(\PDO::FETCH_ASSOC); 
    
                }else{
    
                    throw new \Exception("usuario não encontrado");
                }

          
            
        }

        public static function create($data)
        {
            $connPdo = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME.';port='.DBPORT, DBUSER, DBPASS);

            $sql = 'INSERT INTO '.self::$table.' (email, password, name) VALUES (:em, :pa, :na)';
            $stmt = $connPdo->prepare($sql);
            $stmt->bindValue(':em', $data['email']);
            $stmt->bindValue(':pa', md5($data['password']));
            $stmt->bindValue(':na', $data['name']);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return 'Usuário(a) inserido com sucesso!';
            } else {

                throw new \Exception("Falha ao Criar o  usuário(a)!");
            }
        }

        public static function update($id , $data)
        {

            $connPdo = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);

            $sql = 'UPDATE '.self::$table.' SET  email= :email, password= :password , name= :name  WHERE id = :id';
            $stmt = $connPdo->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':email', $data['email']);
            $stmt->bindValue(':password', md5($data['password']));
            $stmt->bindValue(':name', $data['name']);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return 'Usuário(a) Alterado com sucesso!';
            } else {

                throw new \Exception("Falha ao alterar usuário(a)!");
            }

        }

        public static function delete($id)
        {

            $connPdo = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);

            $sql = 'DELETE  FROM '.self::$table.' WHERE id= :id';
            $stmt = $connPdo->prepare($sql);
            $stmt->bindValue(':id', $id);

            if($stmt->execute()){
                return 'Usuário(a) foi excluido !';
            } else {

                throw new \Exception("Falha ao excluir usuário(a)!");
            }

        }

        public static function verificationUserExist($email){

            $connPdo = new \PDO(DBDRIVE.':host='.DBHOST.';dbname='.DBNAME.';port='.DBPORT, DBUSER, DBPASS);

            $sql = 'SELECT *  FROM '.self::$table.' WHERE email= :email';
            $stmt = $connPdo->prepare($sql);
            $stmt->bindValue(':email', $email);
            $stmt->execute();

            if($stmt->rowCount() > 0){

                return $stmt->fetchAll(\PDO::FETCH_ASSOC); 

            }else{

                return false;
            }

        }


    }