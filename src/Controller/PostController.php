<?php

namespace App\Controller;

use App\Services\FileUploder;
use App\Services\Notification;
use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post", name="post.")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(PostRepository $postRepository)
    {
        $posts = $postRepository->findall();

        //dump($posts);
        return $this->render('post/index.html.twig', [
          'posts' => $posts
        ]);
    }

    /**
     * @Route("/create", name="create")
     * @param Request #$request
     * @param FileUploder $fileuploder
     * @return Response
     */

    //public function create(Request $request)
    public function create(Request $request,FileUploder $fileuploder, Notification $notification)
    {
      $post = new Post();
      $form = $this->createForm(PostType::class, $post);

      $form->handleRequest($request);
      //$form->getErrors();
      //if($form->issubmitted() && $form->isValid()){
      if($form->issubmitted()){
        //Entity Manager
        $em = $this->getDoctrine()->getManager();
        $file = $request->files->get('post')['attechment'];

        if($file){
        /*  $filename = md5(uniqid()) . '.' . $file->guessClientExtension();

          $file->move(
            $this->getParameter('upload_dir'),
            $filename
          );
          */

          $filename =  $fileuploder->uploadFile($file);
          $post->setImage($filename);
          $em->persist($post);
          $em->flush();
        }
        return $this->redirect($this->generateUrl('post.index'));
      }

      $this->addFlash('success',"Post was created");
      //Return a resoponse
      return $this->render('post/create.html.twig',[
          'form' => $form->createView()
        ]
      );
    }

    /**
    * @Route("/show/{id}",name="show")
    * @param Post $post
    * @param Response
    **/

    //public function show($id, PostRepository $postRepository)
    public function show(Post $post)
    {
        //$post = $postRepository->findPostWithCategory($id);
        //dump($post);
        return $this->render('post/show.html.twig',[
          'post' => $post
        ]);
    }

    /**
    * @Route("/delete/{id}",name="delete")
    *
    **/

    public function remove(Post $post){

      $em = $this->getDoctrine()->getManager();

      $em->remove($post);
      $em->flush();
      $this->addFlash('success',"Post was Deleted");

      return $this->redirect($this->generateUrl('post.index'));
    }
}
