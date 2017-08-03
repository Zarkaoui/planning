<?php
/**************************************
 Cree le: 14-12-2010
 Derniere modification: 23-11-2015
 Cree par: JC Prin
**************************************

Copyright (C) 2010  PRIN Jean-Charles

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

******************************************************************************/

class MySQL {
   
	private $dbHost;
	private $dbUser;
	private $dbPass;
	private $dbName;
	private $idConn = NULL;
	private $result;
   
	/***
	* @desc   : Constructeur de la classe
	* @param  : none
	* @return : none
	*/ 
	public function __construct($dbhost, $dbuser, $dbpass,$dbname) {
   
		$this->dbHost = $dbhost;
		$this->dbUser = $dbuser;
		$this->dbPass = $dbpass;
		$this->dbName = $dbname;
   
	}//end __construct()
   

	/***
	* @desc   : Connexion a la base de donnees
	* @param  : none
	* @return : none
	*/
	public function connect() {
	  
		//connexion au serveur mysql
		$this->idConn = mysqli_connect($this->dbHost,$this->dbUser,$this->dbPass);

		if( !$this->idConn ) {
			//erreur
		} else {
			//Une connexion est etablie on selectionne notre BD
			$this->selectDB();
		}
   
	}//end connect()
  

	/***
	* @desc   : Selectionne une BD
	* @param  : none
	* @return : none
	*/
	public function selectDB() {
   
	if( !mysqli_select_db($this->idConn,$this->dbName) ) {
		//Si la BD n'est pas selectionnee
		//erreur
	}
	    
   }//end selectDB()
   
	 
	/***
	* @desc   : Execute une requete SQL
	* @param  : String SQL
	* @return : Bool
	*/
	public function query($sql) {
   
		if( $this->idConn == NULL) {
			//pas de connexion etablie a un serveur 
			//erreur
		}

		//Test de la chaine 
		if( is_string($sql) ) {
			if( !$this->result = mysqli_query($this->idConn,$sql) ) {		      
				//erreur  
				return false;			  
			} else {		     
				//On test si c'est une requete SELECT
				if( stristr(strtoupper($sql), 'SELECT') == true ) {
					$resArray = array();
					$i = 0;
					//On construit notre $resArray
					while( $row = mysqli_fetch_assoc($this->result) ) {				        
						$resArray[$i] = $row;						
						++$i;						  
					}				 
					//On libere la ressource
					mysqli_free_result($this->result);
					//On retourne le resultat
					return $resArray;				 
				} else {
					//c'est n'est pas une requete SELECT 
					return true;			  
				}		
			}		 
		} else {
			//erreur la requete doit etre une chaine
			return false; 
		}	 	  	  
	}
   

	/***
	* @desc   : Insere des donnees dans une table;
	* @param  : String table, Array fieldArray
	* @return : Bool
	*/
	public function insert ($table,$fieldArray){
     
		//Requete SQL Partie 1 : 'INSERT INTO table'
		$sql = 'INSERT INTO `'.$table.'`';

		//Recuperation des champs
		$fieldsName = array_keys($fieldArray);

		//Partie 2: '(`champ1`,`champ2`,...,`champN`)'
		$sql .= '(`'.implode('`,`',$fieldsName).'`) ';

		//Requete SQL Partie 3-1 : 'VALUES(' 
		$sql .= 'VALUES (';

		//Recuperation des valeurs des champs
		$fieldsValue = array_values($fieldArray);

		//Reconstitution du tableau sous la forme 'val1','val2','valN'
		foreach( $fieldsValue as $v ) {
			if( strcmp($v,"NULL") == 0 ) $tampon[] = 'NULL';
			else $tampon[] = "'".mysqli_real_escape_string($this->idConn,$v)."'";	//on echappe les caracteres   
		}
	  
		//Requete SQL Partie 3-2 '`val1`,`valN`)'
		$sql .= implode(",",$tampon).")";

		//Execution de la requete
		if ( $this->query($sql) ) {	      
			return true;	 
		} else {
			//erreur
			if (DEBUG) echo "Query: ".$sql;
			return false;	 
		}	  	  
	}//end insert()


	/***
	* @desc   : MAJ des donnees dans une table
	* @param  : String table, Array fieldArray, String where
	* @return : Bool
	*/
	public function update($table,$fieldArray,$where){
   
		//Test de l'existence de la clause 'WHERE'
		if( !empty ($where) ) {
	     
			$sql = 'UPDATE `'.$table.'` SET ';

			//Recuperation des champs
			$fieldsName = array_keys($fieldArray);

			//Recuperation des valeurs des champs
			$fieldsValue = array_values($fieldArray);
			$nbFields = count($fieldsName);
			
			//Boucle pour construire la requete SQL
			for( $i = 0; $i < $nbFields; ++$i ) {
		 
				$k = $fieldsName[$i];
				$v = $fieldsValue[$i];
			   
				//Si l'une des valeur est 'NULL'
				if( strcmp($v,'NULL') == 0 ) {				  
					//On reconstitue la requete avec la valeur du champ null en vue de debogage
					$sql .= $k. '= NULL';
					break;				   
				} else {
					$sql .= '`'.$k.'`'. "='".mysqli_real_escape_string($this->idConn,$v)."'";	//on echappe les caracteres 
					$sql .= ( ($i == ($nbFields - 1))?'':' , ');
				}
			}	   
			
			$sql .= ' WHERE '.$where;
			
			//Execution de la requete
			if ( !$this->query($sql) ) {
	   			//erreur
				if (DEBUG) echo "Query: ".$sql;
 				return FALSE;
			} else {
	  			return TRUE;
			}
		}
	}//end update()
   

	/***
	* @desc   : Supprime des donnees d'une ou plusieurs table
	* @param  : String table || Array table, String innerOrLeft, String attrib ,String where
	* @return : bool
	*/
	public function delete($table,$innerOrLeft,$attrib,$where) {
      
		//Test de l'existence de la clause 'WHERE'
		if( !empty( $where ) )  {
	      		//verifier s'il s'agit d'un delete d'une table ou plusieurs
			if( is_array ($table) ) {
		     	//Delete sur plusieurs tables
				$sql = 'DELETE FROM `'.$table[0].'`';
				$nbTables = count($table);

				for( $i = 1; $i < $nbTables ; ++$i ) {
					$sql .= ' '.(!empty($innerOrLeft)?$innerOrLeft:'INNER').' JOIN `'.$table[$i].'`';  
				}

				$sql .= ' USING ('.$attrib.') WHERE '.$where;
				//Execution de la requete
				$delValidate = $this->query(sql);
			} else {
				//Delete sur une seule table
				$sql = 'DELETE FROM `'.$table.'` WHERE '.$where;
				//Execution de la requete
				$delValidate = $this->query($sql);
			}
		 
			if( !$delValidate ) {			 
				//erreur
				if (DEBUG) echo "Query: ".$sql;
				return false;			 
			} else {
				return true;			 
			}  
		}   
	}//end delete() 
	 

	/***
	* @desc   : Retourne le nombre de resultat
	* @param  : Mysql ressource result
	* @return : Int nbresult
	*/
	public function numRows($result) {   
		return count($result);   
	}//end numRows()


	/***
	* @desc   : Retourne le dernier ID insere
	* @param  : 
	* @return : Int last insert ID
	*/
	public function lastID() {   
		return mysqli_insert_id($this->idConn);	  
	}//end lastID()

	/***
	* @desc   : Destructeur
	* @param  : none
	* @return : none
	*/
	public function close() {
		if(!@mysqli_close($this->idConn)){ 
			//erreur
		}
   	}//end destruct()
   
}//end MySQL

?>
