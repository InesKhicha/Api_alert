<?php
namespace AppBundle\Service;

use Psr\Log\LoggerInterface;

class SMSService
{
    const BASE_URL = 'https://api.smspartner.fr/v1/send';

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function sendSms($apiKey, $phoneNumber, $message)
    {
        $data = [
            'apiKey' => $apiKey,
            'phoneNumbers' => $phoneNumber,
            'message' => $message,
        ];

        $this->logger->info('Attempting to send SMS', $data);

        // Test de connexion simple
        $this->testApiConnection();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::BASE_URL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        curl_setopt($ch, CURLOPT_VERBOSE, true);
        $verbose = fopen('php://temp', 'w+');
        curl_setopt($ch, CURLOPT_STDERR, $verbose);

        curl_setopt($ch, CURLOPT_CAINFO, 'C:\\xampp\\apache\\bin\\cacert.pem');

        $response = curl_exec($ch);
        $error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        rewind($verbose);
        $verboseLog = stream_get_contents($verbose);
        $this->logger->debug('cURL verbose log', ['log' => $verboseLog]);

        if ($response === false) {
            $this->logger->error('cURL error', ['error' => $error]);
            curl_close($ch);
            return null;
        }

        curl_close($ch);

        $this->logger->info('SMS API response', ['response' => $response, 'httpCode' => $httpCode]);

        return json_decode($response, true);
    }
    private function testApiConnection()
    {
        $ch = curl_init('https://api.smspartner.fr/v1/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CAINFO, 'C:\\xampp\\apache\\bin\\cacert.pem');
        $response = curl_exec($ch);
        $error = curl_error($ch);
        if ($response === false) {
            $this->logger->error('API connection test failed', ['error' => $error]);
        } else {
            $this->logger->info('API connection test', ['response' => $response]);
        }
        curl_close($ch);
    }
}