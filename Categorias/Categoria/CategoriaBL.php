<?php
    require_once '../../Conexion.php';
    require_once '../DTO/CategoriaDTO.php';

    class CategoriaBL
    {
        private $conn;
        public function __Construct()
        {
            $this-> conn = new Conexion();
        }

        public function create($categoriaDTO)
        {
            $eror1 = false;
            $this-> conn -> OpenConnection();
            $connsql = $this -> conn -> GetConnection();  
            $lastInsertId = 0;

            try {
                if($connsql)
                {
                    $connsql->beginTransaction();
                    $sqlStatment = $connsql->prepare(
                        "INSERT INTO category VALUES(
                            default,
                            :name,
                            current_date
                        )"
                    );

                    $sqlStatment->bindParam(':name', $categoriaDTO->Nombre);
                    
                    $sqlStatment->execute();

                    $lastInsertId = $connsql->lastInsertId();
                    $connsql->commit();
                    $eror1 = true;
                }
            } catch (PDOException $e) {
                $connsql->rollBack();
                $eror1 = false;
            }
            return $lastInsertId;
            return $eror1;
        }

        public function Read($Id)
        {
            $this->conn->OpenConnection();
            $connsql = $this->conn->GetConnection();
            $arrayCategoria = new ArrayObject();
            $SQLQuery = "SELECT * FROM category";
            $categoriaDTO = new CategoriaDTO();
            if($Id > 0)
                $SQLQuery = "SELECT * FROM category WHERE category_id ={$Id}";

            try {
                if($connsql)
                {
                    foreach($connsql->query($SQLQuery) as $row )
                    {
                        $categoriaDTO = new CategoriaDTO(); //inicializacion de una nueva instancia 
                        $categoriaDTO->Id = $row['category_id'];
                        $categoriaDTO->Nombre = $row['name'];
                        
                        $arrayCategoria->append($categoriaDTO); //tomar los datos de la columnas y mapear a propiedades del objeto DTO
                    }
                }
            } catch (PDOException $e) {
                
            }
            return $arrayCategoria;
        }

        public function Update($categoriaDTO)
        {
            $Error2 = false;
            $this-> conn -> OpenConnection();
            $connsql = $this -> conn -> GetConnection(); 

            try {
                if($connsql)
                {
                    $connsql->beginTransaction();
                    $sqlStatment = $connsql->prepare(
                        "UPDATE category SET
                            name = :name
                            last_update = current_date
                        WHERE category_id = :id"
                    );

                    $sqlStatment->bindParam(':name', $categoriaDTO->Nombre);
                    
                    $sqlStatment->bindParam(':id', $categoriaDTO->Id);
                    $sqlStatment->execute();

                    $connsql->commit();
                    $Error2 = true;
                    return true;
                    
                }
            } catch (PDOException $e) {
                $connsql->rollBack();
                echo $e;
                $Error2 = false;
            }
        }

        public function Delete($Id)
        {
            $Error = false;
            $this-> conn -> OpenConnection();
            $connsql = $this -> conn -> GetConnection();  

            try {
                if($connsql)
                {
                    $connsql->beginTransaction();
                    $sqlStatment = $connsql->prepare(
                        "DELETE FROM  category
                         WHERE category_id = :id
                        "
                    );

                    $sqlStatment->bindParam(':id', $Id);
                    //$sqlStatment->bindParam(':first_name', $actorDTO->Nombre);
                    //$sqlStatment->bindParam(':last_name', $actorDTO->Apellidos);
                    $sqlStatment->execute();

                    $connsql->commit();
                    $Error = true;
                }
            } catch (PDOException $e) {
                $connsql->rollBack();
                $Error = false;
            }

            return $Error;
        }
    }
    
    
    
    
    

    
    
    

?>