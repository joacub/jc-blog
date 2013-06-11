<?php
namespace JcBlog\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as ORMExt;

/**
 * @ORM\Entity
 * @ORM\Table(name="post")
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    public $id;

    /**
     * @ORM\Column(type="string")
     */
    public $title;

    /**
     * @ORM\Column(type="text")
     */
    public $intro;

    /**
     * @ORM\Column(type="text")
     */
    public $content;

    /**
     * @ORMExt\Slug(fields={"title"})
     * @ORM\Column(type="string")
     */
    public $slug;

    /**
     * @ORM\Column(type="datetime")
     * @ORMExt\Timestampable(on="create")
     */
    public $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @ORMExt\Timestampable(on="update")
     */
    public $updated_at;
}
