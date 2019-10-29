<?php

namespace App\Controller;

use App\Entity\News;
use App\Entity\Handler;
use App\Form\FormEditNews;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class EventController extends AbstractController
{
    /**
     * @Route("/update/{id}", name="update_news")
     */
    public function new($id, Request $request)
    {
		$news = new News();
		
		// Обьявление новой сущности получения старых данных
		$news_data = new News();
		
		$em = $this->getDoctrine()->getManager();
		$news_data = $em->getRepository(News::class)->find($id);
		
		$form_edit_news = $this->createFormBuilder($news)
            ->add('title', TextType::class, ['label' => 'Загаловок', 'attr' => ['value' => $news_data->s_title]])
			->add('desc', TextareaType::class, ['label' => 'Описание', 'data' => $news_data->s_desc])
			->add('category', ChoiceType::class, array(
				'choices'  => array(
					'Политика' => 'policy',
					'Технологии' => 'technologies',
					'Погода' => 'weather',
					'Экономика' => 'economy',
					'Происшествия' => 'incidents',
				),
				'label' => 'Категория',
				'data' => $news_data->s_category
			))
			->add('image', FileType::class, ['label' => 'Картинка', 'required' => false])
            ->add('save', SubmitType::class, array('label' => 'Отредактировать новость'))
            ->getForm();
		
		if(!empty($news_data)){
			if($request->getMethod() === 'POST') {
				$form_edit_news->handleRequest($request);
				$news = $form_edit_news->getData();
				
				if(!empty($news->s_title) && $news->s_title != $news_data->s_title){
					$news_data->setTitle($news->s_title);
				}
				if(!empty($news->s_desc) && $news->s_desc != $news_data->s_desc){
					$news_data->setDesc($news->s_desc);
				}
				if(!empty($news->s_category) && $news->s_category != $news_data->s_category){
					$news_data->setCategory($news->s_category);
				}
				if(!empty($news->s_image) && $news->s_image != $news_data->s_image){
					
					$file = $news->getImage();
					if(!empty($file)){
						if(!empty($news_data->s_image) && file_exists($this->getParameter('upload_img_directory').'/'.$news_data->s_image)){
							unlink($this->getParameter('upload_img_directory').'/'.$news_data->s_image);
						}
						$наndler = new Handler();
						$fileName = $наndler->saveImage($file, $this->getParameter('upload_img_directory'));
						
						$news_data->setImage($fileName);
					}
				}
				
				$em->flush();
				return $this->redirectToRoute('main');
			}
		}
		
        $em->flush();
		return $this->render('theme/index.html.twig', array(
			'template' => 'edit',
            'form_edit_news' => $form_edit_news->createView()
        ));
    }
	
	/**
	 * @Route("/remove/{id}", name="remove_news")
	 */
	public function removeAction($id)
	{
		$news = new News();
		
		$em = $this->getDoctrine()->getManager();
		$news = $em->getRepository(News::class)->find($id);
		
		if(!empty($news)){
			$em->remove($news);
			if(!empty($news->s_image) && file_exists($this->getParameter('upload_img_directory').'/'.$news->s_image)){
				unlink($this->getParameter('upload_img_directory').'/'.$news->s_image);
			}
		}
		
		$em->flush();
		return $this->redirectToRoute('main');	
	}
}