<?php
namespace JcBlog\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as ORMExt;
use Zend\Form\Annotation as Form;

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
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @Form\Options({"label" : "Titulo"})
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Form\Options({"label" : "Introducción"})
     */
    protected $intro;

    /**
     * @ORM\Column(type="text" nullable=true)
     * @Form\Options({"label" : "Contenido"})
     */
    protected $content;

    /**
     * @ORMExt\Slug(fields={"title"})
     * @ORM\Column(type="string")
     * @Form\Options({"label" : "Url (slug)"})
     */
    protected $slug;

    /**
     * @ORM\Column(type="datetime")
     * @ORMExt\Timestampable(on="create")
     * @Form\Exclude()
     */
    protected $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @ORMExt\Timestampable(on="update")
     * @Form\Exclude()
     */
    protected $updated_at;
    
	/**
	 * @return the $id
	 */
	public function getId ()
	{
		return $this->id;
	}

	/**
	 * @param field_type $id
	 */
	public function setId ($id)
	{
		$this->id = $id;
	}

	/**
	 * @return the $title
	 */
	public function getTitle ()
	{
		return $this->title;
	}

	/**
	 * @param field_type $title
	 */
	public function setTitle ($title)
	{
		$this->title = $title;
	}

	/**
	 * @return the $intro
	 */
	public function getIntro ()
	{
		return $this->intro;
	}

	/**
	 * @param field_type $intro
	 */
	public function setIntro ($intro)
	{
		$this->intro = $intro;
	}

	/**
	 * @return the $content
	 */
	public function getContent ()
	{
		return $this->content;
	}

	/**
	 * @param field_type $content
	 */
	public function setContent ($content)
	{
		$this->content = $content;
	}

	/**
	 * @return the $slug
	 */
	public function getSlug ()
	{
		return $this->slug;
	}

	/**
	 * @param field_type $slug
	 */
	public function setSlug ($slug)
	{
		$this->slug = $slug;
	}

	/**
	 * @return the $created_at
	 */
	public function getCreated_at ()
	{
		return $this->created_at;
	}

	/**
	 * @param field_type $created_at
	 */
	public function setCreated_at ($created_at)
	{
		$this->created_at = $created_at;
	}

	/**
	 * @return the $updated_at
	 */
	public function getUpdated_at ()
	{
		return $this->updated_at;
	}

	/**
	 * @param field_type $updated_at
	 */
	public function setUpdated_at ($updated_at)
	{
		$this->updated_at = $updated_at;
	}

}
