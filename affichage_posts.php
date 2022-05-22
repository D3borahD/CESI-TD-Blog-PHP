<?php 
    use TDCesi\Autoloader;
    use TDCesi\Models\PostBlog;

    $pageTitle = 'Liste des articles';

    require_once 'Autoloader.php';
    //permet d'instancier automatiquement les classes chargées
    Autoloader::register();

    include_once('components/header.php');
    include_once('components/navbar.php');

    /**
     * intencie le modèle
     * fait appel à la requête préparée permettant d'afficher tous les posts
     */
    $model = new PostBlog;
    $posts = $model->findAll();
?>

<div class="container">
    <section >
        <h2>Liste des articles</h2>
   
        <!-- parcours l'ensemble des posts de la BDD et les affiche -->
        <?php foreach($posts as $post): ?>
            <article class="card m-3">
                <div class="card-body">
                    <!--SECURITE : failles XSS -->
                    <h2 class="card-title"><a href="affichage_post.php?id=<?= $post->id ?>"><?= htmlentities($post->title) ?></a></h2>
                    <p class="card-text">Publié le : <?= $post->created_at ?></p>
                    <div class="card-text"><?= htmlentities($post->content) ?></div>
                </div>
               
            </article>
         <?php endforeach; ?>
    </section>
</div>
<?php include_once('components/footer.php'); ?>