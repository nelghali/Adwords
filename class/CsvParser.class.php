<?php
  	
  	/**
  	 * @brief Prend en charge les fichiers CSV.
  	 */
  	class ParserCsv {
 	  const SEPARATOR = '|'; //!< Séparateur de champ par défaut
  
  	  private $file      = null;            //!< Nom du fichier CSV
 	  private $separator = self::SEPARATOR; //!< Le séparateur utilisé
  	  private $fields    = 0;               //!< Le nombre de champs du fichier
  	  private $lines     = 0;               //!< Le nombre de lignes du fichier
  	  private $content   = null;            //!< Tableau des valeurs du fichier
  	  private $goodcsv   = false;           //!< Information sur la validité du fichier
 
  	  /**
  	   * @brief Le constructeur
  	   *
 	   * Prend obligatoirement en argument le nom du fichier CSV. Si le fichier 
  	   * existe, il est aussitôt lu pour déterminer sa validité : s’il est valide,
  	   * les différentes valeurs sont stockées et sont accessibles.
  	   * Pour savoir si le fichier est valide, après l’appel du constructeur, il 
  	   * faut utiliser la méthode $this->isGoodCsv().
 	   */
  	  public function __construct($file){
  	    if(file_exists($file)){
  	      $this->file = $file;
  	      $this->isWellFormed();
  	    } else {
  	      $this->goodcsv = false;
  	    }
  	  }
 
  	  /**
  	   * @brief Détermine si un nombre donné est bien compris dans l’intervalle des index de lignes.
  	   *
  	   * @param $integer Un entier
  	   * @return Booléen
  	   */
  	  private function isInRangeOfRows($integer){
  	    if($integer >= 0 and $integer < $this->lines)
  	      return true;
  	    else
  	      return false;
  	  }
  
  	  /**
  	   * @brief Détermine si un nombre donné correspond à un index possible pour un champ du fichier.
  	   *
  	   * @param $integer Un entier
  	   * @return Booléen
  	   */
  	  private function isInRangeOfFields($integer){
  	    if($integer >= 0 and $integer < $this->fields)
  	      return true;
  	    else
  	      return false;
  	  }
  
  	  /**
  	   * @brief Teste si le fichier est un CSV correct.
  	   *
  	   * Pour être correct, le CSV doit comporter un nombre identique de séparateur 
  	   * sur chaque ligne : sinon, il n’est pas bon.
  	   *
  	   * Si le fichier est bon, il y a également des valeurs fournies à la classe 
  	   * comme le nombre de champs du fichier, le nombre de lignes et le contenu du 
 	   * fichier dans un tableau.
  	   */
  	  private function isWellFormed(){
  	    if(!is_null($this->file)){
  	     $lines = file($this->file, FILE_IGNORE_NEW_LINES);
  	     $nbl   = count($lines);

  	      for ($i = 0 ; $i < $nbl ; $i++){
  		if($i > 0)
  		  $nbs2 = $nbs1;
  
  		$nbs1 = substr_count($lines[$i], $this->separator);
  		
  		if($i > 0 and $nbs1 != $nbs2)
  		  $this->goodcsv = false;
  	      }
 
	      // comme c’est bon, on connaît le nombre de champs
 	      $this->fields  = $nbs1 + 1;
  	      // on a le nombre de lignes aussi
  	      $this->lines   = $nbl;
  	      $this->content = $lines;
  	      $this->goodcsv = true;
  	    } else {
 	      $this->goodcsv = false;
 	    }
 	  }
 
 	  /**
105 	   * @brief Détermine si le fichier est un bon CSV
106 	   *
107 	   * Si le fichier est une bon fichier CSV, alors retourne @c vrai, et @c faux 
108 	   * dans le cas contraire.
109 	   *
110 	   * @return Booléen
111 	   */
 	  public function isGoodCsv(){
 	    return $this->goodcsv;
	  }
 	  /**
117 	   * @brief Détermine le caractère séparateur de champs
118 	   *
119 	   * Fixe le caractère séparateur utilisé dans le fichier CSV.
120 	   * Si aucune valeur n’est fournie, le caractère utilisé est un point virgule.
121 	   *
122 	   * @param $separator 
123 	   */
 	  public function setSeparator($separator = ';'){
 	    if(strlen(trim($separator)) == 1 and !is_null($separator)){
 	      $this->separator = $separator;
 	      return true;
 	    } else {
 	      return false;
 	    }
 	  }
 
 	  /**
134 	   * @brief Retourne le nombre de lignes du fichier.
135 	   *
136 	   * @return Entier
137 	   */
 	  public function getNumberOfLines(){
 	    return $this->lines;	  }
 
 	  /**
143 	   * @brief Retourne le nombre de champs du fichier.
144 	   *
145 	   * @return Entier
146 	   */
 	  public function getNumberOfFields(){
 	    return $this->fields;
 	  }

 	  /**
152 	   * @brief Retourne un tableau de la ligne choisie.
153 	   *
154 	   * Retourne un @c tableau si tout va bien, dans le cas contraire, retourne le
155 	   * booléen @c false.
156 	   *
157 	   * @return Tableau ou booléen 
158 	   */
 	  public function getLine($number){
 	    if(is_null($this->content))
 	      return false;
 	    
 	    if($this->isInRangeOfRows($number))
	      return explode($this->separator,$this->content[$number]);
 	    else
 	      return false;
 	  }
 
	  /**
170 	   * @brief Retourne le contenu d’un champ à une ligne précise.
171 	   *
172 	   * Retourne la valeur si tout va bien, ou un booléen @c false dans le cas
173 	   * contraire.
174 	   *
175 	   * @return Chaîne de caractères ou booléen
176 	   */
 	  public function getFieldAtLine($field, $line){
	    if($this->isInRangeOfFields($field)){
 	      $row = $this->getLine($line);
 	      
 	      if($row === false)
 		return false;
 	      
 	      return $row[$field];
 	    } else {
 	      return false;
 	    }
 	  }
 	}
?>