<?php

namespace Websms\SmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Websms\SmsBundle\Entity\Group;
use Websms\SmsBundle\Entity\Contact;
use Websms\SmsBundle\Form\CreateContact;
use Websms\SmsBundle\Form\CreateGroup;

class AddressbookController extends Controller
{
    /**
     * Create new group
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
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
            $group->setUserId($user->getId());

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

    /**
     * List groups
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
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

    /**
     * Edit group
     *
     * @param $groupId
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function groupeditAction($groupId, Request $request)
    {
        $pageTitle = $this->get('translator')->trans('Group');
        $group = $this->get('sms.group.repository')->find($groupId);
        $user = $this->getUser();

        if (!$group) {
            return $this->redirect($this->generateUrl('_groups'));
        }

        $form = $this->createForm(new CreateGroup(), $group);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $name = $form->get('name')->getData();
            $description = $form->get('description')->getData();
            $group->setUserId($user->getId());

            // Create group
            $group->setName($name);
            $group->setDescription($description);

            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('Group edited'));

            return $this->redirect($this->generateUrl('_groups'));
        }

        return $this->render('SmsBundle:Addressbook:create_group.html.twig', array(
            'page_title' => $pageTitle,
            'form' => $form->createView()
        ));
    }

    /**
     * Delete group
     *
     * @param $groupId
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function groupdeleteAction($groupId)
    {
        $group = $this->get('sms.group.repository')->find($groupId);

        if (!$group) {
            return $this->redirect($this->generateUrl('_groups'));
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($group);
        $em->flush();

        return $this->redirect($this->generateUrl('_groups'));
    }

    /**
     * Create contact
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createcontactAction(Request $request)
    {
        $pageTitle = $this->get('translator')->trans('Create new contact');
        $user = $this->getUser();

        $contact = new Contact();

        $form = $this->createForm(new CreateContact(), $contact);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $name = $form->get('name')->getData();
            $number = $form->get('number')->getData();

            // Create group
            $contact->setName($name);
            $contact->setNumber($number);
            $contact->setUserId($user->getId());

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('Contact created'));

            return $this->redirect($this->generateUrl('_create_address_book_item'));
        }

        return $this->render('SmsBundle:Addressbook:create_contact.html.twig', array(
            'page_title' => $pageTitle,
            'form' => $form->createView()
        ));
    }

    /**
     * List contacts
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactsAction()
    {
        $pageTitle = $this->get('translator')->trans('Contacts');
        $contacts = $this->get('sms.contact.repository')->findAll();
        $page = $this->get('request')->query->get('page', 1);
        $groupsPerPage = 10;

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $contacts,
            $page,
            $groupsPerPage
        );

        $pageDataFrom = ($page * $groupsPerPage) - $groupsPerPage + 1;
        $pageDataTo = $pageDataFrom + $groupsPerPage - 1;

        return $this->render('SmsBundle:Addressbook:contacts.html.twig', array(
            'page_title' => $pageTitle,
            'contacts' => $pagination,
            'pageDataFrom' => $pageDataFrom,
            'pageDataTo' => $pageDataTo
        ));
    }

    /**
     * Edit contact
     *
     * @param $contactId
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editcontactAction($contactId, Request $request)
    {
        $pageTitle = $this->get('translator')->trans('Edit contact');
        $user = $this->getUser();

        $contact = $this->get('sms.contact.repository')->find($contactId);

        if (!$contact) {
            return $this->redirect($this->generateUrl('_address_book_items'));
        }

        $form = $this->createForm(new CreateContact(), $contact);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $name = $form->get('name')->getData();
            $number = $form->get('number')->getData();
            $group = $form->get('group')->getData();

            // Create group
            $contact->setName($name);
            $contact->setNumber($number);
            $contact->setGroup($group);
            $contact->setUserId($user->getId());

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('Contact edited'));

            return $this->redirect($this->generateUrl('_address_book_items'));
        }

        return $this->render('SmsBundle:Addressbook:create_contact.html.twig', array(
            'page_title' => $pageTitle,
            'form' => $form->createView()
        ));
    }

    /**
     * Delete contact
     *
     * @param $contactId
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deletecontactAction($contactId, Request $request)
    {
        $contact = $this->get('sms.contact.repository')->find($contactId);

        if (!$contact) {
            return $this->redirect($this->generateUrl('_address_book_items'));
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();

        return $this->redirect($this->generateUrl('_address_book_items'));
    }
}
