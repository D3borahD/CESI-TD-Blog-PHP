<?php
namespace TDCesi\Models;

// importe PDO de PHP
use PDO;
use PDOException;

class Connexion extends PDO {
  // crée une instance unique de la classe
  private static $instance;

  // informations de connexion 
  private const DBHOST = 'localhost:8889';
  private const DBUSER = 'root';
  private const DBPASS = 'root';
  private const DBNAME = 'blog';

  private function __construct(){
    // DSN de connexion 
    $_dsn = 'mysql:dbname=' . self::DBNAME . ';host=' . self::DBHOST;

    try {
      // appelle le constructeur de la classe PDO
    parent::__construct($_dsn, self::DBUSER, self::DBPASS);

    // paramètre les messages d'erreur, le fetch mode, et utf8 sur la DB
    $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES utf8");
    $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }catch(PDOException $e){
      die("Erreur : ".$e->getMessage());
    } 
    finally {
      $_dsn=null;
    }
  } 

  // génère l'instance si elle n'existe pas encore ou en crée une
  public static function getInstance():PDO {
    // vérifie si l'instance est null
    if(self::$instance === null){
      self::$instance = new Connexion();
    }
    // sinon, retourne l'instance elle-même
    return self::$instance;
  }
  
 
 
}