<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Tutorial;
use AppBundle\Entity\Video;

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
    public function oMnieAction()
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
     * @Route("/deleteFromBusket/{id}", name="delete_from_busket")
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
     * @Route("/{id}/tutorial/{id_video}", defaults={"id_video"=0})
     */
    public function tutorialByIdAction($id,$id_video)
    {
        $em=$this->getDoctrine()->getManager();
        $videos=$em->getRepository('AppBundle:Video')->findByTutorial($id);


        $tutorial=$em->getRepository('AppBundle:Tutorial')->findById($id);

        $comments=$em->getRepository('AppBundle:Comment')->findByVideo($id_video);


        return $this->render('body/videos.html.twig',
            ['tutorial'=>$tutorial,
                'videos'=>$videos,
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
        $tutorials = $session->get('tutorial');
            if (!in_array($id, $tutorials)) {
                $tutorials[] = $id;
                $session->set('tutorial', $tutorials);
            }
        return $this->redirectToRoute('koszyk');
    }
}
