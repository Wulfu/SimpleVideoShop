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
    public function koszykAction()
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->render('body/koszyk.html.twig');
        }

        return $this->redirect("/login");
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
}
