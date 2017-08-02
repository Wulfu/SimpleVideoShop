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
        return $this->render('body/koszyk.html.twig');
    }

    /**
     * @Route("/{id}/tutorial")
     */
    public function tutorialByIdAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $videos=$em->getRepository('AppBundle:Video')->findByTutorial($id);
        return $this->render('body/videos.html.twig',['arr'=>$videos]);
    }


}
