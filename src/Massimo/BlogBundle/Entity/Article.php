<?php

namespace Massimo\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
//use Massimo\BlogBundle\Entity\Commentaire;

/**
 * Article
 *
 * @ORM\Table(name="sym_article")
 * @ORM\Entity(repositoryClass="Massimo\BlogBundle\Entity\ArticleRepository")
 */
class Article
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\Length(min=4, minMessage="Le titre doit faire au moins {{ limit }} caractères.")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     * @Assert\Length(min=20, minMessage="Le contenu doit faire au moins {{ limit }} caractères.")
     */
    private $contenu;

    /**
     * @var string
     *
     * @ORM\Column(name="auteur", type="string", length=255, nullable=true)
     * @Assert\Length(min=2, minMessage="L'auteur doit donner au moins les initiales.")
     */
    private $auteur;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreation", type="datetime")
     * @Assert\DateTime()
     */
    private $datecreation;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="publication", type="boolean")
     */
    private $publication;
    
    /**
     * @ORM\OneToOne(targetEntity="Massimo\BlogBundle\Entity\Image", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $image;
    
    /**
     * @ORM\ManyToMany(targetEntity="Massimo\BlogBundle\Entity\Categorie")
     */
	private $categories;

	/**
	 * @ORM\OneToMany(targetEntity="Massimo\BlogBundle\Entity\Commentaire", mappedBy="article", cascade={"persist","remove"})
	 */
	private $commentaires;
	
	/**
	 * @ORM\Column(name="slug", type="string", length=255)
	 */
	private $slug;
	
    public function __construct() {
    	$this->datecreation = new \DateTime();
    	$this->publication = true;
    	
    	$this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    	//$this->commentaires = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     * @return Article
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set auteur
     *
     * @param string $auteur
     * @return Article
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return string 
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set datecreation
     *
     * @param \DateTime $datecreation
     * @return Article
     */
    public function setDatecreation($datecreation)
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    /**
     * Get datecreation
     *
     * @return \DateTime 
     */
    public function getDatecreation()
    {
        return $this->datecreation;
    }

    /**
     * Set publication
     *
     * @param boolean $publication
     * @return Article
     */
    public function setPublication($publication)
    {
        $this->publication = $publication;

        return $this;
    }

    /**
     * Get publication
     *
     * @return boolean 
     */
    public function getPublication()
    {
        return $this->publication;
    }
    
    
    /**
     * Add Categories
     * 
     * @param \Massimo\BlogBundle\Entity\Categorie $categories
     * @return Article
     */
    public function addCategorie (\Massimo\BlogBundle\Entity\Categorie $categories) {
    	$this->categories[] = $categories;
    	return $this;
    }
    
    /**
     * Remove Categories
     *
     * @param \Massimo\BlogBundle\Entity\Categorie $categories
     */
    public function removeCategorie (\Massimo\BlogBundle\Entity\Categorie $categories) {
    	$this->categories->removeElement (categories);
    }
    
    /**
     * Get Categories
     *
     * @return \Massimo\BlogBundle\Entity\Categorie $categories
     */
    public function getCategorie () {
    	return $this->categories;
    }

    /**
     * Set image
     *
     * @param \Massimo\BlogBundle\Entity\Image $image
     * @return Article
     */
    public function setImage(\Massimo\BlogBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Massimo\BlogBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add categories
     *
     * @param \Massimo\BlogBundle\Entity\Categorie $categories
     * @return Article
     */
    public function addCategory(\Massimo\BlogBundle\Entity\Categorie $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Massimo\BlogBundle\Entity\Categorie $categories
     */
    public function removeCategory(\Massimo\BlogBundle\Entity\Categorie $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add commentaires
     *
     * @param \Massimo\BlogBundle\Entity\Commentaire $commentaires
     * @return Article
     */
    public function addCommentaire(\Massimo\BlogBundle\Entity\Commentaire $commentaires)
    {
        $this->commentaires[] = $commentaires;

        return $this;
    }

    /**
     * Remove commentaires
     *
     * @param \Massimo\BlogBundle\Entity\Commentaire $commentaires
     */
    public function removeCommentaire(\Massimo\BlogBundle\Entity\Commentaire $commentaires)
    {
        $this->commentaires->removeElement($commentaires);
    }

    /**
     * Get commentaires
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Article
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
