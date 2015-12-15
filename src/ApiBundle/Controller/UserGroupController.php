<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AdminBundle\Entity\UserGroup;
use AdminBundle\Form\UserGroupType;


class UserGroupController extends Controller
{
    /**
     * @Route("/group-list")
     *
     * @Method("GET")
     */
    public function groupListAction($format)
    {
        $em = $this->getDoctrine()->getManager();

        $userGroups = $em->getRepository('AdminBundle:UserGroup')->findAll();

        return $this->getResponse($userGroups, $format);
    }

    /**
     * @Route("/group/new")
     *
     * @Method("GET")
     */
    public function newAction(Request $request, $format)
    {
        $name = filter_var($request->query->get('name'), FILTER_SANITIZE_STRING);

        if(!$name) {
            return new Response('Group name not found.', 500);
        }

        $userGroup = new UserGroup();
        $userGroup->setName($name);

        $em = $this->getDoctrine()->getManager();
        $em->persist($userGroup);
        $em->flush();

        return $this->getResponse($userGroup, $format);
    }

    private function getResponse($data, $format) {
        $serializer = $this->get('jms_serializer');
        $jsonContent = $serializer->serialize($data, $format);

        return new Response($jsonContent);
    }
}
