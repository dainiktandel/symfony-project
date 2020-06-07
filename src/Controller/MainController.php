<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
		//return new Response('<h1>Hello Symfony</h1>');
		return $this->render('home/index.html.twig');
    }
    
    /**
     * @Route("/viewtest", name="viewtest")
     */
    public function viewtest()
    {
		//return new Response('<h1>Hello Symfony</h1>');
		return $this->render('home/index.html.twig');
    }
    
    /**
     * @Route("/custom/{name?}", name="custom")
     * @param Request $request
     * @return Response
     */
    public function custom(Request $request)
    {
    	//dump($request->get('name'));
    	$name = $request->get('name');
    	//return new Response('<h1>New custom function '.$name.'</h1>');
    	return $this->render('home/custom.html.twig',[
    		'name' => $name
    	]);
    }
    
    
}
