<?php

namespace Websms\SmsBundle\Service;

use Websms\SmsBundle\Repository\ProviderRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MessageSender implements MessageSenderInterface
{
    private $providerRepository;

    private $providerService;

    /**
     * Constructor
     *
     * @param ProviderRepository $providerRepository
     * @param ProviderService $providerService
     */
    public function __construct(ProviderRepository $providerRepository, ProviderService $providerService)
    {
        $this->providerRepository = $providerRepository;
        $this->providerService = $providerService;
    }

    /**
     * Send single sms
     *
     * @param $message
     * @param $sender
     * @param $destination
     *
     * @return bool
     */
    public function sendSms($message, $sender, $destination)
    {
        $sendUrl = $this->providerService->createUrl($message, $sender, $destination);

        if (!file_get_contents($sendUrl)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Send bulk sms
     *
     * @param $message
     * @param $sender
     * @param UploadedFile $file
     *
     * @return bool
     */
    public function sendBulk($message, $sender, UploadedFile $file)
    {
        $fileobj = $file->openFile('r');

        $numbers = $fileobj->fgetcsv(",");

        foreach($numbers as $number) {
            $this->sendSms($message, $sender, $number);
        }

        return true;
    }

    /**
     * Send messages from addressbook
     *
     * @param $message
     * @param $sender
     * @param $numbers
     *
     * @return bool
     */
    public function sendAddressbook($message, $sender, $numbers)
    {
        foreach($numbers as $number) {
            $this->sendSms($message, $sender, $number->getNumber());
        }

        return true;
    }
}
