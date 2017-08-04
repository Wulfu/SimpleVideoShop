<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ClientOrder;
use AppBundle\Entity\Comment;
use AppBundle\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Tutorial;
use AppBundle\Entity\Video;
use AppBundle\Entity\User;
use Symfony\Component\Validator\Constraints\DateTime;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function kursyAction()
    {
        $em=$this->getDoctrine()->getManager();
        $tutorials=$em->getRepository('AppBundle:Tutorial')->findAll();
        return $this->render('body/kursy.html.twig',['arr'=>$tutorials]);
    }

    /**
     * @Route("/o_mnie", name="o_mnie")
     */
    public function AboutMeAction()
    {
        return $this->render('body/o_mnie.html.twig');
    }

    /**
     * @Route("/koszyk", name="koszyk")
     */
    public function koszykAction(Request $request)
    {
        $tutorialsToBuy = [];
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $tutorials = $session->get('tutorial');
        if(isset($tutorials)) {
            foreach ($tutorials as $tutorialId) {
                $tutorialsToBuy[] = $em->getRepository('AppBundle:Tutorial')->findById($tutorialId);
            }
        }
        return $this->render('body/koszyk.html.twig', [
            'tutorials' => $tutorialsToBuy
        ]);
    }

    /**
     * @Route("/deleteFromBusket/{id}", name="delete_from_busket", requirements={"id": "\d+"})
     */
    public function deleteFromBusketAction(Request $request, $id){

        $session = $request->getSession();
        $tutorials = $session->get('tutorial');
        if(($key = array_search($id, $tutorials)) !== false) {
            unset($tutorials[$key]);
            $session->set('tutorial', $tutorials);
        }
        return $this->redirectToRoute('koszyk');
    }

    /**
     * @Route("/{id}/tutorial/{id_video}", defaults={"id_video":"1"})
     */
    public function tutorialByIdAction(Request $request, $id, $id_video)
    {
        $em=$this->getDoctrine()->getManager();

        $videos=$em->getRepository('AppBundle:Video')->findByTutorial($id);

        $video=$em->getRepository('AppBundle:Video')->findById($id_video);

        $tutorial=$em->getRepository('AppBundle:Tutorial')->findById($id);
        $comments=$em->getRepository('AppBundle:Comment')->findByVideo($id_video);

        $comment = new Comment();
        $user = $this->container->get('security.context')->getToken()->getUser();



        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $time = (new \DateTime());
            $comment->setData(($time));
            $comment->setUser($user);
            $comment->setVideo($video[0]);

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
        }


        return $this->render('body/videos.html.twig', [
            'tutorial'=>$tutorial,
            'videos'=>$videos,
            'form'=> $form->createView(),
            'comments'=>$comments]);

    }

    /**
     * @Route("/buy/{id}")
     */
    public function buyTutorialAction(Request $request, $id){

        $session = $request->getSession();
        if(null === $session->get('tutorial')){
            $session->set('tutorial', []);
        }

        $user = $this->container->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $clientOrder = $em->getRepository('AppBundle:ClientOrder')->findByUser($user);
        foreach($clientOrder as $singleOrder){
            $tutorialId = $singleOrder->getTutorial()->getId();
            if($tutorialId === intval($id)){
                $session->getFlashBag()->add('info', 'Posiadasz już ten kurs.');
                return $this->redirectToRoute('moje_kursy');
            }
        }
        $tutorials = $session->get('tutorial');
            if (!in_array($id, $tutorials)) {
                $tutorials[] = $id;
                $session->set('tutorial', $tutorials);
            }
        return $this->redirectToRoute('koszyk');
    }

    /**
     * @Route("/realizacja")
     */
    /*TODO add date to order*/
    public function orderRealisationAction(Request $request){

        $session = $request->getSession();
        $tutorials = $session->get('tutorial');
        $em = $this->getDoctrine()->getManager();
        $coins=0;
        /* to correct */
        foreach ($tutorials as $id){
            $tutorial=$em->getRepository('AppBundle:Tutorial')->findById($id);
            $coins+=$tutorial[0]->getCoins();
        }
        $user=$this->container->get('security.context')->getToken()->getUser();
        $user_coins = $user->getUserCoins();

        if($coins>$user_coins){
            $session->getFlashBag()->add('info', 'Nie masz wystarczających środków aby dokonać zakup');
            return $this->redirectToRoute('koszyk');
        }else{
            foreach ($tutorials as $id){
                $tutorial=$em->getRepository('AppBundle:Tutorial')->findOneById($id);
                $order=new ClientOrder();
                $order->setUser($user);
                $order->setTutorial($tutorial);
                $em->persist($order);
                $em->flush();
            }
            $user->setUserCoins($user_coins-$coins);
            $em->flush();
            $session->invalidate();
            unset($tutorials);

            return $this->redirect('/');
        }
    }

    /**
     * @Route("/moje_kursy", name="moje_kursy")
     */
    public function UserBasketAction(Request $request){
        $user = $this->container->get('security.context')->getToken()->getUser();
        $clientOrders = $user->getClientOrders();


        //$em = $this->getDoctrine()->getManager();
        //$tutorials = $em->getRepository('AppBundle:Tutorial')->findById($id);

        return $this->render('body/client_videos.html.twig', [
            'clientOrders' => $clientOrders
        ]);
    }
    /**
     * @Route("moje_kursy/tutorial/videos/{id}", name="moje_kursy_tutorial")
     */
    public function showClientTutorial($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tutorial=$em->getRepository('AppBundle:Tutorial')->findById($id);
        return $this->render('client_videos/tutorial_view.html.twig', [
            'tutorial' => $tutorial
        ]);
    }

}
