<?php 
    // création d'un alias pour utiliser le namespace
    use TDCesi\Autoloader;
    use TDCesi\Models\PostBlog;

    $pageTitle = 'Mon Blog';

    // permet de ne pas effectuer d'include à chaque fichier à charger
    require_once 'Autoloader.php';
    Autoloader::register();

    // si la variable post n'est pas vide
    if(!empty($_POST)){
        
        // vérifie si le post est complet (titre, contenu et image) et sans erreur
        if(
            isset($_POST["title"], $_POST["content"], $_FILES["picture"]) &&
           !empty($_POST["title"]) && !empty($_POST["content"]) 
            && !empty($_FILES["picture"]["error"] === 0)
            ){
                /**
                 * Traitement de l'image
                 * vérifie l'extention et le type Mime (.png -> image/png)
                 */
                $allowed= [
                    "jpg" => "image/jpeg",
                    "jpeg" => "image/jpeg",
                    "png" => "image/png"
                ];

                // récupère les informations du fichier
                $filename = $_FILES["picture"]["name"];
                $filetype = $_FILES["picture"]["type"];
                $filesize = $_FILES["picture"]["size"];

                // met le nom et l'extension du fichier en minuscules
                $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                // vérifie l'absence de l'extention dans les clés de $allowed ou l'absence du type mime
                if(!array_key_exists($extension, $allowed) || !in_array($filetype, $allowed)){
                    // l'extention et/ou le type sont incorrects
                    die("Erreur: format de fichier incorrect");
                }

                // On limite à 2 Mo
                if($filesize > 2000000) {
                    die("Fichier trop volumineux ");
                }

                /**
                 * génère un nom unique 
                 * uniqid est un timestamp md5 permet de le chiffer
                 */
                $newname = md5(uniqid());
                // génère le chemin d'accès
                $newfilename = __DIR__ . "/uploads/$newname.$extension";

                // on récupère le chemin du dossier temporaire dans lequel est enregistré le fichier
                if(!move_uploaded_file($_FILES["picture"]["tmp_name"], $newfilename)) {
                    die("L'upload à échoué");
                }

                /**
                 * SECURITE : changer le mode du fichier pour qu'il ne soit pas éxécuté (si le fichier est un script)
                 * 6 écriture + lecture , 4 lecture
                 */
                chmod($newfilename, 0644);

                $fichier = "$newname.$extension";
               
                //redimentione l'image avant enregistrement
                $info = getimagesize($newfilename);
                
                // récupère les infos largeur et hauteur du fichier
                $largeur = $info[0];
                $hauteur = $info[1];
                // indique la largeur de sortie de la nouvelle image
                $resizeLargeur = 450;
                // calcule de la hauteur de sortie de la nouvelle image
                $resizehauteur = 450 * $hauteur / $largeur;
                // crée une nouvelle image vierge en mémoire
                $nouvelleImage = imagecreatetruecolor($resizeLargeur, $resizehauteur);

                // ouvre l'image source
                switch($info["mime"]){
                    case "image/png":
                        $imageSource = imagecreatefrompng($newfilename);
                        break;
                    case "image/jpeg":
                        $imageSource = imagecreatefromjpeg($newfilename);
                        break;
                    default:
                    die("Format d'image incorrect");
                }
                /**
                 * copie l'image source dans l'image destination en la réduisant
                 * resampled => optimise les pixels lors de la réduction
                 */
                imagecopyresampled(
                    $nouvelleImage, //image de destination
                    $imageSource, // image de source
                    0, //position en x du coin supérieur gauche dans l'image de destination
                    0, //position en y du coin supérieur gauche dans l'image de destination
                    0, //position en x du coin supérieur gauche dans l'image source
                    0, //position en y du coin supérieur gauche dans l'image source
                    $resizeLargeur,  //largueur dans l'image de destination 
                    $resizehauteur,//hauteur dans l'image de destination 
                    $largeur,//largueur dans l'image source
                    $hauteur,//hauteur dans l'image source
                );

                 //supprime l'image source pour ne pas avoir de doublon dans le dossier
                 unlink($newfilename);

                // enregistre la nouvelle image sur le serveur
                switch($info["mime"]){
                    case "image/png":
                        imagepng($nouvelleImage, __DIR__ . "/uploads/resize-".$fichier);
                        break;
                    case "image/jpeg":
                        imagejpeg($nouvelleImage, __DIR__ . "/uploads/resize-".$fichier);
                        break;
                    default:
                    die("Format d'image incorrect");
                    }
                    // détruit les images dans la mémoire
                    imagedestroy($imageSource);
                    imagedestroy($nouvelleImage);

                    // récupère le path de la nouvelle image
                    $path_image = "uploads/resize-".$fichier;

                        // le formulaire est complet
                        // récupère les données en les protegeant faille XSS
                        $title = htmlspecialchars($_POST["title"]);
                        $content = htmlspecialchars($_POST["content"]); 
                        $picture = $path_image; 

                /**
                 * Ajout d'un nouveau post
                 */
                $post= new PostBlog;

                    $newPost = $post
                        ->setTitle($title)
                        ->setContent($content)
                        ->setPathImage($path_image);
                    $post->addPost($newPost);

        } else {
            // envoi une erreur si le formulaire incomplet 
            die("le formulaire est incomplet ou l'image envoyées est trop volumineuse");
        }
    }

    $pageTitle = 'Confirme';
    @include_once("components/header.php");
    @include_once("components/navbar.php");
?>
<div class="container">
    <div class="alert alert-success">
        <p>Aucune erreur dans le transfert du fichier</p>
        <p>Le fichier <?= $filename ?> a été copié dans le répertoire photos</p>
        <p>Ajout du commentaire réussi</p>
    </div>
    <a href="affichage_posts.php"> Affichage blog</a>
</div>
   
<?php @include_once("components/footer.php");