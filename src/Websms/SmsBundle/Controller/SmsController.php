<?php

namespace Websms\SmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Websms\SmsBundle\Entity\Message;
use Websms\SmsBundle\Form\SendSms;
use Websms\SmsBundle\Form\SendBulk;
use Websms\SmsBundle\Form\SendAddressbook;

class SmsController extends Controller
{
    /**
     * Send single sms
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $pageTitle = $this->get('translator')->trans('Send SMS');
        $user = $this->getUser();

        $messageObject = new Message();
        $messageObject->setUserId($user->getId());

        $form = $this->createForm(new SendSms(), $messageObject);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            $message = $data->getMessage();
            $destination = $data->getDestination();
            $sender = $data->getSender();

            // Send message
            $messageSender = $this->get('sms_sender');
            if ($messageSender->sendSms($message, $sender, $destination)) {
                $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('Message Sent'));
            } else {
                $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('Message Sent Error'));
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($messageObject);
            $em->flush();

            return $this->redirect($this->generateUrl('_send_sms'));
        }

        return $this->render('SmsBundle:Sms:index.html.twig', array(
            'page_title' => $pageTitle,
            'form' => $form->createView()
        ));
    }

    /**
     * Send bulk sms
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function bulkAction(Request $request)
    {
        $pageTitle = $this->get('translator')->trans('Send Bulk SMS');

        $messageObject = new Message();
        $form = $this->createForm(new SendBulk(), $messageObject);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $file = $form->get('bulkFile')->getData();
            $sender = $form->get('sender')->getData();
            $message = $form->get('message')->getData();

            // Send message
            $messageSender = $this->get('sms_sender');
            if ($messageSender->sendBulk($message, $sender, $file)) {
                $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('Message Sent'));
            } else {
                $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('Message Sent Error'));
            }

            return $this->redirect($this->generateUrl('_sms_bulk'));
        }

        return $this->render('SmsBundle:Sms:send_bulk.html.twig', array(
            'page_title' => $pageTitle,
            'form'       => $form->createView()
        ));
    }

    public function addressAction(Request $request)
    {
        $pageTitle = $this->get('translator')->trans('Send Bulk Address');

        $form = $this->createForm(new SendAddressbook());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $group = $form->get('group')->getData();
            $sender = $form->get('sender')->getData();
            $message = $form->get('message')->getData();

            $numbers = $this->get('sms.contact.repository')->findByGroup($group);

            // Send message
            $messageSender = $this->get('sms_sender');
            if (empty($numbers)) {
                $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('No numbers found'));
            } elseif ($messageSender->sendAddressbook($message, $sender, $numbers)) {
                $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('Message Sent'));
            } else {
                $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('Message Sent Error'));
            }

            return $this->redirect($this->generateUrl('_sms_address'));
        }

        return $this->render('SmsBundle:Sms:send_addressbook.html.twig', array(
            'page_title' => $pageTitle,
            'form'       => $form->createView()
        ));
    }
}
