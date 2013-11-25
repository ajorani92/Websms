<?php

namespace Websms\SmsBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class MessageSenderInterface
 *
 * Interface to be implemented by MessageSender service for sending sms messages
 *
 * @package Websms\SmsBundle\Service
 */
interface MessageSenderInterface
{
    /**
     * Send single sms message
     *
     * @param $message
     * @param $sender
     * @param $destination
     *
     * @return boolean
     */
    public function sendSms($message, $sender, $destination);

    /**
     * Send bulk sms message
     *
     * @param $message
     * @param $sender
     * @param UploadedFile $file
     *
     * @return boolean
     */
    public function sendBulk($message, $sender, UploadedFile $file);

    /**
     * Send messages from addressbook
     *
     * @param $message
     * @param $sender
     * @param $numbers
     *
     * @return mixed
     */
    public function sendAddressbook($message, $sender, $numbers);
}
