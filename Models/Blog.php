<?php
    // creation d'un namespace afin de ne pas être en conflit potentiel avec d'autre librairie
    namespace TDCesi\Models;

    use TDCesi\Models\Connexion;

    class Blog extends Connexion 
    {
        // table de la base de donnée
        protected $table;
        // intance de connexion
        private $db;

        /**
         * CRUD
         */

        // méthode pour aller chercher tous les posts et les ordonner dans l'ordre décroissant
        public function findAll()
        {
            $query = $this->requete("SELECT * FROM {$this->table} ORDER BY `created_at` DESC");
            return $query->fetchAll();
        }

        // méthode pour aller cherche un seul post
        public function find(int $id)
        {
            // exécute la requête
            return $this->requete("SELECT * FROM {$this->table} WHERE id = $id")->fetch();
        }

        // methode pour créer un post
        public function addPost()
        {
            $champs = [];
            $inter = [];
            $valeurs = [];

            // boucle pour éclater le tableau
            foreach($this as $champ => $valeur) {
                // filtre le retour des valeurs pour ne pas retourner des valeurs vides ou relatives à la table ou la BDD
                if($valeur !== null && $champ != 'db' && $champ != 'table'){
                    $champs[]=$champ;
                    $inter[]="?";
                    $valeurs[]=$valeur;
                }
            }

            // transforme le tableau "champs" en une chaine de caractère
            $liste_champs = implode(', ', $champs);
            $liste_inter = implode(', ', $inter);

            // exécute la requête
            return $this->requete('INSERT INTO '.$this->table.' ('. $liste_champs.')VALUES('.$liste_inter.')', $valeurs);
        }
     
        // méthode pour gérer les requêtes préparées ou non préparées
        public function requete(string $sql, array $attributs = null)
        {
            // récupère l'instance de connexion
            $this->db = Connexion::getInstance();
            // vérifie si il a des attributs 
            if($attributs !== null){
                //requete préparée
                $query = $this->db->prepare($sql);
                $query->execute($attributs);
                return $query;
            }else {
                //requete simple
                return $this->db->query($sql);
            }
        }
    }
?> 