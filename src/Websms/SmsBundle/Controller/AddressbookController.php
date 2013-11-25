<?php

namespace Websms\SmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Websms\SmsBundle\Entity\Group;
use Websms\SmsBundle\Form\CreateGroup;

class AddressbookController extends Controller
{
    public function groupcreateAction(Request $request)
    {
        $pageTitle = $this->get('translator')->trans('Create new group');
        $user = $this->getUser();

        $group = new Group();

        $form = $this->createForm(new CreateGroup(), $group);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $name = $form->get('name')->getData();
            $description = $form->get('description')->getData();

            // Create group
            $group->setName($name);
            $group->setDescription($description);

            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('Group created'));

            return $this->redirect($this->generateUrl('_create_group'));
        }

        return $this->render('SmsBundle:Addressbook:create_group.html.twig', array(
            'page_title' => $pageTitle,
            'form' => $form->createView()
        ));
    }

    public function groupsAction()
    {
        $pageTitle = $this->get('translator')->trans('Groups');
        $groups = $this->get('sms.group.repository')->findAll();
        $page = $this->get('request')->query->get('page', 1);
        $groupsPerPage = 4;

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $groups,
            $page,
            $groupsPerPage
        );

        $pageDataFrom = ($page * $groupsPerPage) - $groupsPerPage + 1;
        $pageDataTo = $pageDataFrom + $groupsPerPage - 1;

        return $this->render('SmsBundle:Addressbook:groups.html.twig', array(
            'page_title' => $pageTitle,
            'groups' => $pagination,
            'pageDataFrom' => $pageDataFrom,
            'pageDataTo' => $pageDataTo
        ));
    }

    public function groupeditAction($groupId)
    {
        $pageTitle = $this->get('translator')->trans('Groups');
        $groups = $this->get('sms.group.repository')->findAll();

        return $this->render('SmsBundle:Addressbook:groups.html.twig', array(
            'page_title' => $pageTitle,
            'groups' => $groups
        ));
    }
}
