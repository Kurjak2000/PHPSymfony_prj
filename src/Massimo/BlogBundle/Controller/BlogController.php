<?php

namespace Massimo\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Massimo\BlogBundle\Entity\Article;
use Massimo\BlogBundle\Entity\Categorie;
use Massimo\BlogBundle\Entity\Commentaire;
use Massimo\BlogBundle\Entity\Image;
use Massimo\BlogBundle\Form\ArticleType;
use Massimo\BlogBundle\Form\DeleteArticleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Massimo\BlogBundle\Serive\Slugger;

class BlogController extends Controller
{
    public function indexAction($page)
    {
    	if ($page < 1) throw $this->createNotFoundException('Page inexistante');
    	
    	$articles = $this->getDoctrine()
    	    ->getManager()
    	    ->getRepository('MassimoBlogBundle:Article')
    	    //->findAll();
    	    ->getArticles();
    	
        return $this->render('MassimoBlogBundle:Blog:index.html.twig', array('articles' => $articles));
    }
    
	/**
	 * 
	 * @param unknown $id
	 * @Route("/Article/{slug}", name="massimo_blog_view_slug")
	 * @Template("MassimoBlogBundle:Blog:view.html.twig")
	 */
    public function viewAction(Article $article)
    { 	
    	return  array('article' => $article);
    }
    
    public function addAction()
    {
    	//$em = $this->getDoctrine()->getManager();
    	 
    	$article = new Article;
    	
    	/*$formBuilder = $this->createFormBuilder($article);
    	
    	$formBuilder
    	   ->add('datecreation',    'date')
    	   ->add('title',           'text')
    	   ->add('contenu',         'textarea')
    	   ->add('auteur',          'text')
    	   ->add('publication',     'checkbox');
    	       	
    	$form = $formBuilder->getForm();
    	*/
    	
    	$form = $this->createForm(new ArticleType, $article);
    	
		$request = $this->getRequest();
		if ($request->getMethod() == "POST") {
			$form->handleRequest($request);
			
			if ($form->isValid()) {
				$slugger = $this->get('massimo_blog.slugger');
				$slug = $slugger->getSlug($article->getTitle());
				$article->setSlug($slug);				
				
				$entityManager = $this->getDoctrine()->getManager();
				$entityManager->persist($article);
				
				try {
					$entityManager->flush();
				} catch (Exception $e) {
					
				}
			}
		}
    	
    	/*$categorie = new Categorie;
    	$categorie->setNom("Mar");
    	
    	$image = new Image;
    	$image->setUrl("giornale.gif");
    	$image->setAlt("Images");
    	
    	$article = new Article;
    	 
    	$article->setTitle('Hello World')
    	->setAuteur('Massimo Carnevali')
    	->setContenu('Ma che bella giornata di sole.')
    	->addCategorie($categorie)
    	->setImage($image)
    	->setPublication (true);
    	
    	
    	$commentaireArt1 = new Commentaire ($article);
    	
    	$commentaireArt1->setAuteur('Maurizio Palermo')
    	->setContenu('Che bel articolo.');
  
    	
    	$em->persist($commentaireArt1);
    	$em->persist($categorie);
    	$em->persist($article);
    	 
    	$em->flush();*/
    	
    	return $this->render('MassimoBlogBundle:Blog:add.html.twig', array('form'=>$form->createView()));
    }
    
    public function addCommentaireAction()
    {
    	$em = $this->getDoctrine()->getManager();

    	$article = $this->getDoctrine()
    	->getRepository('MassimoBlogBundle:Article')
    	->find(1);
    	
    	if (!$article) {
    		throw $this->createNotFoundException(
    				'Aucun produit trouvé pour cet id : '.$id);
    	}
    	
    	$commentaireArt1 = new Commentaire ($article);
    
    	$commentaireArt1->setAuteur('Maurizio Palermo')
    	->setContenu('Che bel articolo.');
    
    	$em->persist($commentaireArt1);
    
    	$em->flush();
    	return $this->render('MassimoBlogBundle:Blog:add.html.twig', array('commentaire'=>$commentaireArt1));
    }
    
    
    
    public function modifyAction($id)
    {
    	$article = $this->getDoctrine()
    	->getManager()
    	->getRepository('MassimoBlogBundle:Article')
    	->getArticle($id);
    	
    	$form = $this->createForm(new ArticleType, $article);
    	
    	$request = $this->getRequest();
    	if ($request->getMethod() == "POST") {
    		$form->handleRequest($request);
    			
    		if ($form->isValid()) {
    			$slugger = $this->get('massimo_blog.slugger');
    			$slug = $slugger->getSlug($article->getTitle());
    			$article->setSlug($slug);
    			
    			$entityManager = $this->getDoctrine()->getManager();
    			$entityManager->persist($article);
    	
    			try {
    				$entityManager->flush();
    			} catch (Exception $e) {
    					
    			}
    		}
    	}
    	
    	return $this->render('MassimoBlogBundle:Blog:modify.html.twig', array('form'=>$form->createView()));
    }
    
    public function deleteAction()
    {	 
    	$form = $this->createForm(new DeleteArticleType);
    	 
    	$request = $this->getRequest();
    	if ($request->getMethod() == "POST" ) {
    		$form->handleRequest($request);
    		 
    		if ($form->isValid()) {
    			//if( $request->get("submit")=="delete");
    			$entityManager = $this->getDoctrine()->getManager();


    			$article = $this->getDoctrine()
    			->getManager()
    			->getRepository('MassimoBlogBundle:Article')
    			//->getArticle($request->get("massimo_blogbundle_deletearticle[article]"));
    			->getArticle($request->request->get('article'));
    			
    			//print_r($article); die();
    			
    			try {
    				$entityManager->remove($article);
    				$entityManager->flush();
    				
    				$this->redirectToRoute("massimo_blog_homepage");
    			} catch (Exception $e) {
    					
    			}
    		}
    	}
    	 
    	return $this->render('MassimoBlogBundle:Blog:delete.html.twig', array('form'=>$form->createView()));
    }
    
    public function testAction() 
    {
    	$article = new Article;
    
    	$article->setDate(new \Datetime());  // Champ « date » OK  
    	$article->setTitle('abc');           // Champ « title » incorrect : moins de 10 caractères   
    	$article->setContent('blabla');    // Champ « content » incorrect : on ne le définit pas
    	$article->setAuthor('AB');            // Champ « author » incorrect : moins de 2 caractères
    
    	// On récupère le service validator
    	$validator = $this->get('validator');

    	// On déclenche la validation sur notre object
    	$listErrors = $validator->validate($article);
    
    	// Si le tableau n'est pas vide, on affiche les erreurs
    	if(count($listErrors) > 0) {
    		return new Response(print_r($listErrors, true));
    	} else {
    		return new Response("L'article est valide !");
    	}
    }
    
    public function menuAction()
    {
    	$articles = array(
    			array ('title' => 'Nipoti di zio Paperone', 'contenu' => 'Qui Quo Qua'),
    			array ('title' => 'Paperino', 'contenu' => 'Paperino esce con Paperina'),
    			array ('title' => 'Gastone', 'contenu' => 'Che fortunato'),
    	);
    	
    	return $this->render('MassimoBlogBundle:Blog:menu.html.twig', array('articles' => $articles));
    }

}
