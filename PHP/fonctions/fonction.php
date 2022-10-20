<?php 
/**
 * Fonctions de connection à la BDD
 *
 */
function db_connect() {
  $dsn = 'mysql:host=localhost;dbname=fredi';  // contient le nom du serveur et de la base
  $user = 'root';
  $password = '';
  try {
    $dbh = new PDO($dsn, $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $ex) {
    die("Erreur lors de la connexion SQL : " . $ex->getMessage());
  }
  return $dbh;
}



function generate_random_letters($length) {         // renvoie chaine de lettres Majuscules aléatoirement
    $random = '';
    for ($i = 0; $i < $length; $i++) {
        $random .= chr(rand(ord('A'), ord('Z')));
    }
    return $random;
}



function getRandomString($n) {     // renvoie chaine de caracteres speciaux aleatoirement 
    $characters = '?!#';
    $randomString = '';
  
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
  
    return $randomString;
}
/**
 * Fonctions de validation
 *
 */

/**
 * Retourne vrai si le champs est vide
 *
 * @param string $field
 * @return boolean
 */
 function is_empty(string $field){
  return empty(trim($field));
 }

/**
 * Retourne vrai si le champs a une longueur minimum
 *
 * @param string $field le champs à vérifier
 * @param int $min la longueur minimum
 * @return boolean vrai si la longueur du champs est >= minimum
 */
function min_length(string $field,int $min){
  return mb_strlen($field) >= $min;
}

/**
 * Retourne vrai si le champs a une longueur maximum
 *
 * @param string $field le champs à vérifier
 * @param int $max la longueur maximum
 * @return boolean vrai si la longueur du champs est <= minimum
 */

function max_length(string $field,int $max){
  return mb_strlen($field) <= $max;
}

/**
 * Retourne vrai si le champs est alphanumérique (lettre ou chiffre)
 *
 * @param string $field le champs à vérifier
 * @return boolean vrai si le champs est alphanumérique (lettre ou chiffre)
 */
function is_alphanum(string $field) {
  return ctype_alnum($field);
}

/**
 * Retourne vrai si le champs ne contient que des lettres majuscules
 *
 * @param string $field le champs à vérifier
 * @return boolean vrai si le champs ne contient que des lettres majuscules
 */
function is_uppercase(string $field) {
  return ctype_upper($field);
}

/**
 * Retourne vrai si le champs ne contient que des lettres minuscules
 *
 * @param string $field le champs à vérifier
 * @return boolean vrai si le champs ne contient que des lettres minuscules
 */
function is_lowercase(string $field) {
  return ctype_lower($field);
}

/**
 *  Retourne vrai si le champs est l'une des valeurs d'un tableau indicé
 *
 * @param string $field le champs à vérifier
 * @param array $values le tableau (indicé) contenant les valeurs
 * @return boolean vrai si le champs est l'une des valeurs du tableau
 */
function contains_value(string $field, array $values){
  return in_array($field,$values);
}

/**
 *  Retourne vrai si le champs est l'une des clés d'un tableau associatif
 *
 * @param string $field le champs à vérifier
 * @param array $keys le tableau (associatif) contenant les clés
 * @return boolean vrai si le champs est l'une des clés du tableau
 */
function contains_key(string $field, array $keys){
  return array_key_exists($field,$keys);
}

/**
 * Retourne vrai si le champs contient au moins un chiffre
 *
 * @param string $field le champs à vérifier
 * @return boolean vrai si le champs contient au moins un chiffre
 */
function contains_num(string $field) {
  return preg_match("#[0-9]#",$field);
}

/**
 * Retourne vrai si le champs contient au moins une minuscule
 *
 * @param string $field le champs à vérifier
 * @return boolean vrai si le champs contient au moins une minuscule
 */
function contains_lowercase(string $field) {
  return preg_match("#[a-z]#",$field);
}

/**
 * Retourne vrai si le champs contient au moins une majuscule
 *
 * @param string $field le champs à vérifier
 * @return boolean vrai si le champs contient au moins une majuscule
 */
function contains_uppercase(string $field) {
  return preg_match("#[A-Z]#",$field);
}

/**
 * Retourne vrai si le champs contient au moins un caractère spécial
 * donc ni un chiffre, ni une lettre, ni _ (underscore)
 * @param string $field le champs à vérifier
 * @return boolean vrai si le champs contient au moins un caractère spécial
 */
function contains_special(string $field) {
  return preg_match("#[\W]#",$field);
}

/**
 * Permet la création de log de connexion/deconnexion
 */
function connection_log($info,$action)
{
    $logfile ='../../htaccess/.htaccess/connection_log.txt';
    $date = date('D, d-m-y h:i:s');
    $logopen=(fopen("$logfile",'a'));
    fwrite($logopen,$date." ".$action." ".$info."\r\n");
    fclose($logopen);
}