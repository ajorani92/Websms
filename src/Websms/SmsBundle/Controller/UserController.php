<?php

namespace Websms\SmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Websms\SmsBundle\Entity\Message;
use Websms\SmsBundle\Form\SendSms;
use Websms\SmsBundle\Form\User;

class UserController extends Controller
{

    /**
     * Create user
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws AccessDeniedException
     */
    public function createAction(Request $request)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $pageTitle = $this->get('translator')->trans('Create user');

        $form = $this->createForm(new User());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $username = $form->get('username')->getData();
            $email = $form->get('email')->getData();
            $password = $form->get('password')->getData();

            $userManager = $this->get('fos_user.user_manager');

            $user = $userManager->createUser();
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPlainPassword($password);
            $user->setEnabled(true);

            $userManager->updateUser($user);

            $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('User created'));

            return $this->redirect($this->generateUrl('_admin_user_edit'));
        }

        return $this->render('SmsBundle:User:create.html.twig', array(
            'page_title' => $pageTitle,
            'form' => $form->createView()
        ));
    }
}
