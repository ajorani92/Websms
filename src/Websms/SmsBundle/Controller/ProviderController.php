<?php

namespace Websms\SmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Websms\SmsBundle\Entity\Provider;
use Websms\SmsBundle\Form\CreateProvider;
use Websms\SmsBundle\Form\SendSms;

class ProviderController extends Controller
{
    public function indexAction(Request $request)
    {
        $providerRepository = $this->getDoctrine()->getRepository('SmsBundle:Provider');

        $providers = $providerRepository->findAll();

        return $this->render('SmsBundle:Provider:index.html.twig', array(
            'page_title' => $this->get('translator')->trans('Provider List'),
            'providers'  => $providers
        ));
    }

    public function createAction(Request $request)
    {
        $provider = new Provider();

        $form = $this->createForm(new CreateProvider(), $provider);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($provider);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('Provider Created'));

            return $this->redirect($this->generateUrl('_provider_create'));
        }

        return $this->render('SmsBundle:Provider:create.html.twig', array(
            'page_title' => $this->get('translator')->trans('Create Provider'),
            'form'       => $form->createView()
        ));
    }

    public function updateAction($providerId, Request $request)
    {
        $providerRepository = $this->getDoctrine()->getRepository('SmsBundle:Provider');

        $provider = $providerRepository->find($providerId);

        if (!$provider) {
            return $this->redirect($this->generateUrl('_provider_list'));
        }

        $form = $this->createForm(new CreateProvider(), $provider);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($provider);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('Provider Updated'));

            return $this->redirect($this->generateUrl('_provider_list'));
        }

        return $this->render('SmsBundle:Provider:create.html.twig', array(
            'page_title' => $this->get('translator')->trans('Update Provider'),
            'form'       => $form->createView()
        ));
    }

    public function deleteAction($providerId)
    {
        $providerRepository = $this->getDoctrine()->getRepository('SmsBundle:Provider');

        $provider = $providerRepository->find($providerId);

        if (!$provider) {
            return $this->redirect($this->generateUrl('_provider_list'));
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($provider);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('Provider Deleted'));

        $providers = $providerRepository->findAll();

        return $this->render('SmsBundle:Provider:index.html.twig', array(
            'page_title' => $this->get('translator')->trans('Provider List'),
            'providers'  => $providers
        ));
    }

    public function setAction()
    {
        $providerRepository = $this->getDoctrine()->getRepository('SmsBundle:Provider');

        $providers = $providerRepository->findAll();
    }
}
