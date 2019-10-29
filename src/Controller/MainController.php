<?php

namespace App\Controller;

use App\Entity\News;
use App\Entity\Handler;
use App\Form\FormAddNews;
use App\Form\FormSearchNews;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
	/**
     * @Route("/main", name="main")
     */
    public function new(Request $request)
    {
		$news = new News();
		$form_search_news = $this->createForm(FormSearchNews::class, $news);
        $form_add_news = $this->createForm(FormAddNews::class, $news);
		$use_search = '';

		if($request->getMethod() === 'POST') {
			if ($request->request->has('form_search_news')) {
				$form_search_news->handleRequest($request);
				
				$em = $this->getDoctrine()->getManager();
				$repository = $em->getRepository(News::class);
				$query = $repository->createQueryBuilder('s')
				   ->where('s.s_title LIKE :word')
				   ->setParameter('word', '%'.$form_search_news->getData()->s_title.'%')
				   ->getQuery();
				$news = $query->getResult();

				$use_search = $form_search_news->getData()->s_title;
			}
			if ($request->request->has('form_add_news')) {
				$form_add_news->handleRequest($request);
				$news = $form_add_news->getData();
				
				$file = $news->getImage();
				if(!empty($file)){
					
					$наndler = new Handler();
					$fileName = $наndler->saveImage($file, $this->getParameter('upload_img_directory'));
					
					$news->setImage($fileName);
				}

				$em = $this->getDoctrine()->getManager();
				$em->persist($news);
				$em->flush();
				return $this->redirectToRoute('main');
			}
		}
		else{
			$news = $this->getDoctrine()->getRepository(News::class)->findAll();
		}
		
		// Если не используется поиск
		if(empty($use_search)){
			$count_full_list = floor(count($news) / 4);
			$residue = count($news) - $count_full_list * 4;
			if($residue > 0){
				$list_data = $count_full_list + 1;
			}
			else{
				$list_data = $count_full_list;
			}
			
			if(empty($request->query->get('page'))){
				$news = array_slice($news, 0, 4); 
				$page = 1;
			}
			else{
				$max_range = $request->query->get('page') * 4;
				$news = array_slice($news, ($max_range - 4), $max_range);
				$page = $request->query->get('page');
			}
		}
		else{
			$list_data = 0;
			$page = 0;
		}
		
		
        return $this->render('theme/index.html.twig', array(
			'template' => 'main',
            'form_add_news' => $form_add_news->createView(),
			'form_search_news' => $form_search_news->createView(),
			'news' => $news,
			'use_search' => $use_search,
			'list_data' => $list_data,
			'page' => $page,
        ));
    }
}