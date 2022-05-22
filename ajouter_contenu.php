<div class="container">

    <h1 class="my-3">Formulaire d'ajout de contenu</h1>

    <form action="./reception_article.php" method="POST" name="form" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Titre :</label>
            <input class="form-control" type="text" name="title">
        </div>
        <div class="form-group my-3">
        <label for="message">Commentaire : </label>
        <textarea class="form-control" name="content" id="" cols="30" rows="10"style="height:100px"></textarea>
        </div>
        <div class="form-group my-3">
            <p>Choisissez une photo avec une taille inférieure à 2 Mo.</p>
            <!-- Permet de limiter de bloquer l'envoi d'image dont la taille est supérieur à 2MO -->
            <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
            <input class="form-control" type="file" name="picture" accept="image/png, image/jpeg">
        </div>
        <input class="btn btn-primary my-3" type="submit" value="Envoyer">
    </form> 

    <a href="affichage_posts.php">Page d'affichage du blog</a>

</div>