<?php



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
        
        $sql = 'INSERT INTO usuario(nombre, apellidos, tipo_id, id, telefono, fecha_cumple, email)
                VALUES ("'.$name.'", "'.$lastN.'","'.$typeID.'","'.$ID.'","'.$phone.'","'.$dateB.'","'.$email.')';
        $this->oMySQL->ejecutarConsultaI($sql);
    }
    
    
    /**
     * Method that deletes an user 
     * @param int $ID
     * @return array
     */
    public function deleteUser($ID){
        return $this->oMySQL->ejecutarConsultaI('DELETE FROM usuario WHERE id="'.$ID.'"');   
    }
    
    /**
     * Method that update information about an user
     * @param varchar $name 
     * @param varchar $lastN
     * @param int $phone
     * @param Date $dateB
     * @param varchar $email
     */
    public function updateUser($name,$lastN,$phone,$dateB,$email){
        $sql = 'UPDATE usuario SET nombre="'.$name.'",apellidos="'.$lastN.'",telefono="'.$phone.'",fecha_cumple="'.$dateB.'",email='.$email.' WHERE id= "'.$ID.'"';
        return $this->oMySQL->ejecutarConsultaI($sql);    
    }
    
    /**
     * This method gets the user's information 
     * @param int $ID
     * @return array
     */
    public function searchUser($ID){
        $sql='SELECT * FROM usuario WHERE id="'.$ID.'"';
        return $this->oMySQL->ejecutarConsultaSelect($sql);
    }
    
    /**
     * This method searches to an user in the BD 
     * if the user is found then return true 
     * @param int $ID
     * @return boolean 
     */
    public function existsUser($ID){
        $sql='SELECT nombre FROM usuario WHERE id="'.$ID.'"';
        $result=$this->oMySQL->ejecutarConsultaSelect($sql);
        if($result==null){
            return false;
        }
        else{
            return true;
        }
    }
    
    
    
    
}

?>
