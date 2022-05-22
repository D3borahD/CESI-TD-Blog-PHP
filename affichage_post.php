<?php 
    use TDCesi\Autoloader;
    use TDCesi\Models\PostBlog;

    require_once 'Autoloader.php';

    //permet d'instantcier automatiquement les classes chargées
    Autoloader::register();
    @include_once('components/header.php');
    @include_once('components/navbar.php');

    /**
     * Vérification :
     * si $id n'est pas défini ou est vide on redirige vers affichage_posts.php et on n'exécute pas le reste de la page
     */
    if(!isset($_GET["id"]) && empty($_GET["id"])) {
        header("Location: affichage_posts.php");
        exit;
    }

    // sinon on poursuit et on récupère l'id dans l'url
    $id=htmlentities($_GET['id']);
    // crée un nouvel objet
    $model = new PostBlog;
    // recherche l'article correspondant à l'id dans l'url
    $post = $model->find($id);

    // si il n'y a pas d'article : on affiche que l'article n'existe pas et on arrête le script
    if(!$post){
        http_response_code(404);
        echo "L'article que vous recherchez n'hésiste pas";
        @include_once('components/footer.php');
        exit;
    }
?>

<div class="container" >
    <section>

    
    <article id="card_one-post" class="card">        
        <div class="card-body">
            <!--SECURITE : failles XSS -->
            <h2 class="card-title"><?= htmlentities($post->title) ?></h2>
            <p class="card-text">Publié le : <?= $post->created_at ?></p>
            <div class="card-text"><?= htmlentities($post->content) ?></div>
        </div>
        
        <img src="<?= $post->path_image ?>" alt="<?= "image de l'article  " . $post->title ?>">
    </article>
    <a href="affichage_posts.php">Page d'affichage du blog</a>
    </section>
</div>

<?php   @include_once('components/footer.php');