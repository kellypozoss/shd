<?php
    
    require_once './CategoriaBL.php';

    
    class CategoriaService {
        private $categoriaDTO;
        private $categoriaBL;
        

        public function __construct() {
            $this->categoriaDTO = new CategoriaDTO();
            $this->categoriaBL = new CategoriaBL();
            
        }

        public function Create( $Nombre){
            $this->categoriaDTO->Nombre = $Nombre;
            if($this->categoriaBL -> Create($this ->categoriaDTO) > 0)
                echo json_encode($this -> categoriaDTO, JSON_PRETTY_PRINT);
            else
                echo json_encode(array());
           
                //echo json_encode(true, JSON_PRETTY_PRINT);

            
        }

        public function Update( $Id, $Nombre){
            $this->categoriaDTO->Id = $Id;
            $this->categoriaDTO->Nombre = $Nombre;
            
            if($this -> categoriaBL -> Update($this -> categoriaDTO) > 0)
                echo json_encode($this -> categoriaDTO, JSON_PRETTY_PRINT);
            else
                echo json_encode(array());
                //echo json_encode($this->actorDTO, JSON_PRETTY_PRINT);
                
            
        }

        public function Delete( $Id){
            $this->categoriaDTO->Id = $Id;
            if($this -> categoriaBL -> Delete($this ->categoriaDTO->Id) > 0)
                echo json_encode($this -> categoriaDTO, JSON_PRETTY_PRINT);
            else
                echo json_encode(array());
            
        }

        public function Read( $Id) {
             
            $this->categoriaDTO = $this->categoriaBL->Read($Id);
            echo json_encode($this->categoriaDTO, JSON_PRETTY_PRINT);
            
        }
    }
    
    $Obj = new CategoriaService();
    
   switch($_SERVER['REQUEST_METHOD']) {
       case 'GET':
            {
                
                if( empty($_GET['param']))
                    $Obj->Read(0);
                else
                {
                    if( is_numeric($_GET['param']))
                         $Obj->Read( $_GET['param']); 
                    else
                    {
                        $categoriaDTO = new CategoriaDTO();
                        $categoriaDTO->Response = array('CODE'=>"ERROR", 'TEXT'=>"El parametro debe ser numerico"); 
                        echo json_encode($categoriaDTO->Response);  
                    }
                         
                }
            break;
            }
        
        case 'POST':{
            
                $data = json_decode(file_get_contents('php://input'), true);
                if((isset($data['Nombre']) && !empty($data['Nombre'])))
                    $Obj->Create( $data['Nombre']);
                else 
                {
                    $categoriaDTO = new CategoriaDTO();
                    $categoriaDTO->Response = array('CODE'=>"ERROR", 'TEXT'=>"Faltan datos"); 
                    echo json_encode($categoriaDTO->Response);  
                }
                 
            
            break;
        }
        case 'PUT':{
            $data = json_decode(file_get_contents('php://input'), true);
                if((isset($data['Id']) && !empty($data['Id'])) && (isset($data['Nombre']) && !empty($data['Nombre'])))
                    $Obj->Update( $data['Id'], $data['Nombre']);
                else 
                {
                    $categoriaDTO = new CategoriaDTO();
                    $categoriaDTO->Response = array('CODE'=>"ERROR", 'TEXT'=>"Faltan datos"); 
                    echo json_encode($categoriaDTO->Response);  
                }
            break;
        }
        case 'DELETE':{
            $data = json_decode(file_get_contents('php://input'), true);
                if((isset($data['Id']) && !empty($data['Id']))) 
                    $Obj->Delete( $data['Id']);
                else 
                {
                    $categoriaDTO = new ActorDTO();
                    $categoriaDTO->Response = array('CODE'=>"ERROR", 'TEXT'=>"Faltan datos"); 
                    echo json_encode($categoriaDTO->Response);  
                }
            break;
            }
        
        default:
        {

        }
        
            
    }
?>