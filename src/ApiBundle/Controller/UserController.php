<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{
    /**
     * @Route("/user-list")
     *
     * @Method("GET")
     */
    public function userListAction($format)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AdminBundle:User')->findAll();

        $serializer = $this->get('jms_serializer');
        $jsonContent = $serializer->serialize($users, $format);

        return new Response($jsonContent);
    }
}
