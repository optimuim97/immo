<?php

namespace App\Helpers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class Utils extends AbstractController
{

    public function __construct(
        private SerializerInterface $serializer,
    ) {
    }

    public static function getJson(
        SerializerInterface $serializer,
        $data,
        string $groupname,
        $ignoreAttributes = []
    ) {
        $dataJson = $serializer->serialize(
            $data,
            JsonEncoder::FORMAT,
            [AbstractNormalizer::GROUPS => $groupname, AbstractNormalizer::IGNORED_ATTRIBUTES => $ignoreAttributes],
        );

        return json_decode($dataJson);
    }

    public static function deserializeJson(
        SerializerInterface $serializer,
        $data,
        $entity,
        string $type = 'json'
    ) {
        $serialized = $serializer->deserialize($data, $entity, $type);
        return $serialized;
    }

    public static function generateRandomString($length = 7)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = substr(str_shuffle($characters), 0, $length);

        return $randomString;
    }

    public static function encrypter($phone_number, $device, $date, $encryptionKey = 'apaym')
    {
        $combine = "$phone_number--$device--$date";
        $encryptedData =  encrypt($combine, $encryptionKey);

        while (str_contains($encryptedData, '/')) {
            $encryptedData =  encrypt($combine, $encryptionKey);
        }

        return $encryptedData;
    }

    public static function decrypter($encryptedData, $encryptionKey)
    {
        return decrypt($encryptedData, $encryptionKey);
    }

    public static function handleError($errors)
    {
        if (count($errors) > 0) {

            $composeError = [];

            foreach ($errors as $error) {
                $composeError[$error->getPropertyPath()] = $error->getMessage();
            }

            return $composeError;
        } else {

            return null;
        }
    }

    public static function validPhoneNumber($phone, $length = 20): bool|string
    {
        if (str_starts_with($phone, "225")) {
            $length = 13;
        }

        $phoneNormalize = normalizeTelephoneNumber($phone);
        if (isDigits($phoneNormalize, maxDigits: $length) && isValidTelephoneNumber($phoneNormalize)) {
            return $phoneNormalize;
        } else {
            return false;
        }
    }

    function getProgramIDbyBank($bank)
    {
        switch ($bank) {
            case 'nsia':
                $this->getParameter('gtp.nsia.program_id');
                break;
            case 'ecobank':
                $this->getParameter('gtp.nsia.program_id');
                break;
            case 'uba':
                $this->getParameter('gtp.nsia.program_id');
                break;
            default:
                $this->getParameter('gtp.program_id');
                break;
        }
    }

}
