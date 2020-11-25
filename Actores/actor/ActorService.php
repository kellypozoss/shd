<?php
    require_once './ActorBL.php';
    class ActorService {
        private $actorDTO;
        private $actorBL;
        

        public function __construct() {
            $this->actorDTO = new ActorDTO();
            $this->actorBL = new ActorBL();
            
        }

        public function Create( $Nombre, $Apellidos){
            $this->actorDTO->Nombre = $Nombre;
            $this->actorDTO->Apellidos = $Apellidos;
            if($this->actorBL -> Create($this -> actorDTO) > 0)
                echo json_encode($this -> actorDTO, JSON_PRETTY_PRINT);
            else
                echo json_encode(array());
           
                //echo json_encode(true, JSON_PRETTY_PRINT);

            
        }

        public function Update( $Id, $Nombre, $Apellidos){
            $this->actorDTO->Id = $Id;
            $this->actorDTO->Nombre = $Nombre;
            $this->actorDTO->Apellidos = $Apellidos;
            if($this -> actorBL -> Update($this -> actorDTO) > 0)
                echo json_encode($this -> actorDTO, JSON_PRETTY_PRINT);
            else
                echo json_encode(array());
                //echo json_encode($this->actorDTO, JSON_PRETTY_PRINT);
                
            
        }

        public function Delete( $Id){
            $this->actorDTO->Id = $Id;
            if($this -> actorBL -> Delete($this ->actorDTO->Id) > 0)
                echo json_encode($this -> actorDTO, JSON_PRETTY_PRINT);
            else
                echo json_encode(array());
            
        }

        public function Read( $Id) {
             
            $this->actorDTO = $this->actorBL->Read($Id);
            echo json_encode($this->actorDTO, JSON_PRETTY_PRINT);
            
        }
    }
    
    $Obj = new ActorService();
    
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
                        $actorDTO = new ActorDTO();
                        $actorDTO->Response = array('CODE'=>"ERROR", 'TEXT'=>"El parametro debe ser numerico"); 
                        echo json_encode($actorDTO->Response);  
                    }
                         
                }
            break;
            }
        
        case 'POST':{
            
                $data = json_decode(file_get_contents('php://input'), true);
                if((isset($data['Nombre']) && !empty($data['Nombre'])) && (isset($data['Apellidos']) && !empty($data['Apellidos'])))
                    $Obj->Create( $data['Nombre'], $data['Apellidos']);
                else 
                {
                    $actorDTO = new ActorDTO();
                    $actorDTO->Response = array('CODE'=>"ERROR", 'TEXT'=>"Faltan datos"); 
                    echo json_encode($actorDTO->Response);  
                }
                 
            
            break;
        }
        case 'PUT':{
            $data = json_decode(file_get_contents('php://input'), true);
                if((isset($data['Id']) && !empty($data['Id'])) && (isset($data['Nombre']) && !empty($data['Nombre'])) && (isset($data['Apellidos']) && !empty($data['Apellidos'])))
                    $Obj->Update( $data['Id'], $data['Nombre'], $data['Apellidos']);
                else 
                {
                    $actorDTO = new ActorDTO();
                    $actorDTO->Response = array('CODE'=>"ERROR", 'TEXT'=>"Faltan datos"); 
                    echo json_encode($actorDTO->Response);  
                }
            break;
        }
        case 'DELETE':{
            $data = json_decode(file_get_contents('php://input'), true);
                if((isset($data['Id']) && !empty($data['Id']))) 
                    $Obj->Delete( $data['Id']);
                else 
                {
                    $actorDTO = new ActorDTO();
                    $actorDTO->Response = array('CODE'=>"ERROR", 'TEXT'=>"Faltan datos"); 
                    echo json_encode($actorDTO->Response);  
                }
        break;
            }
        default:
        {

        }
        
            
    }
?>