<?php
    
    require_once './PeliculaBL.php';


    
    class PeliculaService {
        private $peliculaDTO;
        private $peliculaBL;
        

        public function __construct() {
            $this->peliculaDTO = new PeliculaDTO();
            $this->peliculaBL = new PeliculaBL();
            
        }

        

        public function Read() {
             
            $this->peliculaDTO = $this->peliculaBL->Read();
            echo json_encode($this->peliculaDTO, JSON_PRETTY_PRINT);
            
        }
        public function ReadId( $Id){
             
            $this->peliculaDTO = $this->peliculaBL->ReadId($Id);
            echo json_encode($this->peliculaDTO, JSON_PRETTY_PRINT);
            
        }
    }
    
    $Obj = new PeliculaService();
    
   switch($_SERVER['REQUEST_METHOD']) {
       case 'GET':
            {
                
                if( empty($_GET['param']))
                    $Obj->Read();
                else
                {
                    if( is_numeric($_GET['param']))
                         $Obj->ReadId( $_GET['param']); 
                    else
                    {
                        $peliculaDTO = new ActorDTO();
                        $peliculaDTO->Response = array('CODE'=>"ERROR", 'TEXT'=>"El parametro debe ser numerico"); 
                        echo json_encode($peliculaDTO->Response);  
                    }
                         
                }
            break;
            }

       
        default:
        {

        }
        
            
    }
?>