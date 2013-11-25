<?php

namespace Websms\SmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        $pageTitle = $this->get('translator')->trans('Dashboard');

        return $this->render('SmsBundle:Index:index.html.twig', array(
            'page_title' => $pageTitle,
        ));
    }
}
