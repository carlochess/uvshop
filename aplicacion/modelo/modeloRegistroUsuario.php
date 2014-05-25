<?php


// configurar autoloading
require_once '../libs/vendor/autoload.php';

// configurar Propel
require_once '../libs/generated-conf/config.php';
/**
 * This class contents all functionality about users, as create,delete,modify,search
 *
 * @author Cristian Henao
 */
class modeloRegistroUsuario {
    /**
     *this attribute is in charge of consultations to BD
     * @var MySQL 
     */
    private $oMySQL;
    
    public function __construct(MySQL $db){
        $this->oMySQL = $db;
    }
    /**
     * This method permits create an user
     * $name (varchar)
     * $lastN (varchar)
     * $typeID(varchar)
     * $ID (int)
     * $phone(int)
     * $dateB(Date)  //date of birth
     * $email(varchar)
     * 
     */
    public function createUser($name,$lastN,$typeID,$ID,$phone,$dateB,$email){
        if(($name==null)||($lastN==null)||($typeID==null)||($phone==null)||($dateB==null)||($email==null)){
            throw new Exception('<br> Campos de registros vacios');
        }
            $usuario = new Usuario();
            $usuario->setNombre($name);
            $usuario->setApellidos($lastN);
            $usuario->setTipoId($typeID);
            $usuario->setId($ID);
            $usuario->setTelefono($phone);
            $usuario->setFechaCumple($dateB);
            $usuario->setEmail($email);
            $usuario->save();
            
       // $sql = 'INSERT INTO usuario(nombre, apellidos, tipo_id, id, telefono, fecha_cumple, email)
        //        VALUES ("'.$name.'", "'.$lastN.'","'.$typeID.'","'.$ID.'","'.$phone.'","'.$dateB.'","'.$email.')';
        //$this->oMySQL->ejecutarConsultaI($sql);
    }
    
    
    /**
     * Method that deletes an user 
     * @param int $ID
     * @return array
     */
    public function deleteUser($ID){
        $usuario=\Base\UsuarioQuery::create()
                ->filterById($ID);
        $usuario->delete();
        return $usuario->toArray();
        //return $this->oMySQL->ejecutarConsultaI('DELETE FROM usuario WHERE id="'.$ID.'"');   
    }
    
    /**
     * Method that update information about an user
     * @param varchar $name 
     * @param varchar $lastN
     * @param int $phone
     * @param Date $dateB
     * @param varchar $email
     */
    public function updateUser($ID,$name,$lastN,$phone,$dateB,$email){
        
        \Base\UsuarioQuery::create()
        ->filterById($ID)
        ->update(array('nombre' =>$name, 'apellidos'=>$lastN,'telefono'=>$phone,'fecha_cumple'=>$dateB,'email'=>$email));  
     //   $sql = 'UPDATE usuario SET nombre="'.$name.'",apellidos="'.$lastN.'",telefono="'.$phone.'",fecha_cumple="'.$dateB.'",email='.$email.' WHERE id= "'.$ID.'"';
     //   return $this->oMySQL->ejecutarConsultaI($sql);    
    }
    
    /**
     * This method gets the user's information 
     * @param int $ID
     * @return array
     */
    public function searchUser($ID){
        
        $usuario= \Base\UsuarioQuery::create()
                ->select("*")
                ->filterById($ID)
                ->find();
        return $usuario->toArray();
        //$sql='SELECT * FROM usuario WHERE id="'.$ID.'"';
        //return $this->oMySQL->ejecutarConsultaSelect($sql);
    }
    
    /**
     * This method searches to an user in the BD 
     * if the user is found then return true 
     * @param int $ID
     * @return boolean 
     */
    public function existsUser($ID){
        
        $usuario= \Base\UsuarioQuery::create()
                ->select("nombre")
                ->filterById($ID)
                ->find();
        
       // $sql='SELECT nombre FROM usuario WHERE id="'.$ID.'"';
       // $result=$this->oMySQL->ejecutarConsultaSelect($sql);
        if($usuario==null){
            return false;
        }
        else{
            return true;
        }
    }
    
    
    
    
}

?>
