<?php 
namespace TDCesi\Models;

// indique qu'il n'y a pas d'héritage après cette classe
final class PostBlog extends Blog {

    // variables
    protected $id;
    protected $title;
    protected $content;
    protected $path_image;
    protected $created_at;

    //constructeur
    public function __construct()
    {
        $this->table = 'posts';
    }

    /**
     *  getteurs  && setteur
     */
   

    // id
    public function getId():int{
        return $this->id;
    }
    public function setId(int $id):self{
        $this->id = $id;
        return $this;
    }

    // titre
    public function getTitle():int{
        return $this->title;
    }
    public function setTitle(string $title):self{
        $this->title = $title;
        return $this;
    }

    // contenu
    public function getContent():int{
        return $this->content;
    }
    public function setContent(string $content):self{
        $this->content = $content;
        return $this;
    }

    // path de l'image
    public function getPathImage():int{
        return $this->path_image;
    }
    public function setPathImage(string $path_image):self{
        $this->path_image = $path_image;
        return $this;
    }
    
    // date de création du post
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at):self
    {
        $this->created_at = $created_at;
        return $this;
    }
} 
