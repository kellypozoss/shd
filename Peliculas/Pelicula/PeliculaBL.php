<?php
    require_once '../../Conexion.php';
    require_once '../DTO/PeliculaDTO.php';

    class PeliculaBL
    {
        private $conn;
        public function __Construct()
        {
            $this-> conn = new Conexion();
        }

        

        public function ReadId($Id)
        {
            $this->conn->OpenConnection();
            $connsql = $this->conn->GetConnection();
            $arrayPelicula = new ArrayObject();
           
            $SQLQuery = "SELECT * FROM film WHERE film_id = {$Id}";
            try {
                if($connsql)
                {
                    foreach($connsql->query($SQLQuery) as $row )
                    {
                        $peliculaDTO = new PeliculaDTO(); //inicializacion de una nueva instancia 
                        $peliculaDTO->Id = $row['film_id'];
                        $peliculaDTO->Titulo = $row['title'];
                        $peliculaDTO->Descripcion = $row['description'];
                        $peliculaDTO->Lenguaje = $row['original_language_id'];
                        $peliculaDTO->Lanzamiento = $row['release_year'];
                        $peliculaDTO->Duracion = $row['rental_duration'];
                        $peliculaDTO->Rating = $row['rating'];
                        $peliculaDTO->Actores = self::Actores($Id);
                        $arrayPelicula->append($peliculaDTO); //tomar los datos de la columnas y mapear a propiedades del objeto DTO
                    }
                }
            } catch (PDOException $e) {
                
            }
            return $arrayPelicula;
        }
        public function Read()
        {
            $this->conn->OpenConnection();
            $connsql = $this->conn->GetConnection();
            $arrayPelicula = new ArrayObject();
           
            $SQLQuery = "SELECT * FROM film ";
            try {
                if($connsql)
                {
                    foreach($connsql->query($SQLQuery) as $row )
                    {
                        $peliculaDTO = new PeliculaDTO(); //inicializacion de una nueva instancia 
                        $peliculaDTO->Id = $row['film_id'];
                        $peliculaDTO->Titulo = $row['title'];
                        $peliculaDTO->Descripcion = $row['description'];
                        
                        $arrayPelicula->append($peliculaDTO); //tomar los datos de la columnas y mapear a propiedades del objeto DTO
                    }
                }
            } catch (PDOException $e) {
                
            }
            return $arrayPelicula;
        }
        

        private function Actores($Id)
        {
            $this->conn->OpenConnection();
            $connsql = $this->conn->GetConnection();
            $arrayActores = new ArrayObject();
           
            $SQLQuery = "SELECT * 
                        FROM `film_actor` fa 
                        INNER JOIN actor a ON fa.actor_id= a.actor_id
                        WHERE fa.film_id = {$Id}";
            try {
                if($connsql)
                {
                    foreach($connsql->query($SQLQuery) as $row )
                    {
                        $Actor = Array();
                        
                        $Actor['Nombre'] = $row['first_name'];
                        $Actor['Apellidos'] = $row['last_name'];
                        
                        $arrayActores->append($Actor); //tomar los datos de la columnas y mapear a propiedades del objeto DTO
                    }
                }
            } catch (PDOException $e) {
                
            }
            return $arrayActores;
        }

    }

        

        
    
    
    
    
    

    
    //$actorDTO->Id = 202;
    //$actorDTO->Nombre = "Armando";
    //$actorDTO->Apellidos = "Pozos";
    

    //Agergar actor
    //$actorBL->create($actorDTO);
    
    //Consultar actor
    //print_r($actorBL->Read(201));

    //Modificar actor
    //$actorDTO->Id = 205;
    //$actorDTO->Nombre = "Martin";
    //$actorDTO->Apellidos = "Juarez";
    //$actorBL->Update($actorDTO);

    //Eliminar
    /*$actorDTO->Id = 205;
    $actorDTO->Nombre = "Martin";
    $actorDTO->Apellidos = "Juarez";
    $actorBL->Delete($actorDTO->Id);*/
    

?>