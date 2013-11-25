<?php

namespace Websms\SmsBundle\Service;

use Websms\SmsBundle\Repository\ProviderRepository;

class ProviderService
{
    private $providerRepository;

    public function __construct(ProviderRepository $providerRepository)
    {
        $this->providerRepository = $providerRepository;
    }

    public function createUrl($message, $sender, $destination)
    {
        $provider = $this->providerRepository->findOneBy(array('enabled' => 1));

        $providerHost = $provider->getHost();
        $providerDestination = $provider->getDestination();
        $providerSender = $provider->getSender();
        $providerMessage = $provider->getMessage();

        $url = $providerHost.'&'.$providerDestination.'='.$destination.'&'.$providerSender.'='.urlencode($sender).'&'.$providerMessage.'='.urlencode($message);

        return $url;
    }
}
