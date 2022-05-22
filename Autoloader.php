<?php
// permet de charger automatiquement les classes nécessaires
// le namespace permet de faire référence à "notre lbrairie" et d'être sur de ne pas faire appel par erreur à une autre librairie
namespace TDCesi;
class Autoloader {
    // Enregistre une fonction en tant qu'implémentation de __autoload()
    // fonction qui permet de déclarer quelle méthode ou fonction éxecuter si on tombe sur une classe qu'on ne connait pas 
    static function register(){
        // les méthodes statiques sont accessibles sans avoir besoin d'instantier la classe
        spl_autoload_register([
            //on recherche la classe dans laquelle on se trouve
            __CLASS__, 
            // on lance la fonction autoload
            'autoload'
        ]);
    }

    static function autoload($class){
        // on récupère dans $class la totalité du namespace de la classe concernée
        // on retire le namespace dans le path pour avoir le path d'accès aux fichiers
        $class = str_replace(__NAMESPACE__ . '\\' , '', $class);
        // on remplace les \ par des /
        $class = str_replace('\\', '/', $class);
        // on charge le fichier correspondant

        // on vérifie si le fichier existe
        $fichier = __DIR__ .'/'. $class . '.php';
        if(file_exists($fichier)){
            require_once $fichier;
        }
    }
}
?>