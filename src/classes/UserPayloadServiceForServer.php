<?php


namespace Cryptolib\CryptoCore\Classes;

use Cryptolib\CryptoCore\forms\ErrorForm;
use Cryptolib\CryptoCore\forms\HandlerResultForm;
use Cryptolib\CryptoCore\Forms\TransferDataForm;
use Cryptolib\CryptoCore\Forms\TransferForm;
use Cryptolib\CryptoCore\interfaces\iUserPayloadServiceForServer;
use Cryptolib\CryptoCore\Models\Transfer;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserPayloadServiceForServer implements iUserPayloadServiceForServer
{
    private $client;

    protected $url;

    public function __construct()
    {
        $this->client = new CurlHttpClient();
        $this->url = config("crypto.url");
    }

    private function getContent($response)
    {
        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        return $content;
    }

    public function getTrustedDevicePublicId(): TransferDataForm
    {
        try {
            $response = $this->client->request(
                'GET',
                "$this->url/cryptolib/server/getTrustedDevicePublicId",
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'X-API-VERSION' => '0.0.3'
                    ],
                ]
            );

        } catch (\Exception $e) {

        }

        $tmp = (object)$this->getContent($response);

        $tdf = new TransferDataForm;
        $tdf->setData($tmp->data);
        $tdf->setType($tmp->type);
        return $tdf;
    }

    public function onceEncryptedRequest(): TransferDataForm
    {
        try {
            $response = $this->client->request(
                'GET',
                "$this->url/cryptolib/server/onceEncryptedRequest",
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'X-API-VERSION' => '0.0.3'
                    ],
                ]
            );

        } catch (\Exception $e) {

        }

        $tmp = (object)$this->getContent($response);

        $tdf = new TransferDataForm;
        $tdf->setData($tmp->data);
        $tdf->setType($tmp->type);
        return $tdf;
    }

    public function handler(TransferForm $transfer): HandlerResultForm
    {
        try {
            $response = $this->client->request(
                'POST',
                "$this->url/cryptolib/server/handler",
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'X-API-VERSION' => '0.0.3'
                    ],
                    'json' => $transfer->toJSON(),
                ]
            );

        } catch (\Exception $e) {

        }

        $content = (object)$this->getContent($response);
        $content->incomingTransfer = (object)$content->incomingTransfer;
        $content->incomingTransfer->status = (object)$content->incomingTransfer->status;
        $content->outgoingTransfer = (object)$content->outgoingTransfer;
        $content->outgoingTransfer->status = (object)$content->outgoingTransfer->status;

        $hrf = new HandlerResultForm();

        $incomingTransfer = new TransferForm(
            $content->incomingTransfer->id ?? null,
            $content->incomingTransfer->senderUserId ?? null,
            $content->incomingTransfer->recipientUserId ?? null,
            $content->incomingTransfer->data ?? null,
            $content->incomingTransfer->createDateTime ?? null,
            $content->incomingTransfer->updateDateTime ?? null
        );

        $incomingTransfer->setStatus($content->incomingTransfer->status ?? null);

        $outgoingTransfer = new TransferForm(
            $content->outgoingTransfer->id ?? null,
            $content->outgoingTransfer->senderUserId ?? null,
            $content->outgoingTransfer->recipientUserId ?? null,
            $content->outgoingTransfer->data ?? null,
            $content->outgoingTransfer->createDateTime ?? null,
            $content->outgoingTransfer->updateDateTime ?? null
        );

        $incomingTransfer->setStatus($content->outgoingTransfer->status ?? null);

        $data = $content->data ?? null;

        $hrf->setIncomingTransfer($incomingTransfer);
        $hrf->setOutgoingTransfer($outgoingTransfer);
        $hrf->setData($data);

        return $hrf;
    }

    public function twiceEncryptedRequest(TransferDataForm $transfer): TransferDataForm
    {

        try {
            $response = $this->client->request(
                'POST',
                "$this->url/cryptolib/server/twiceEncryptedRequest",
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'X-API-VERSION' => '0.0.3'
                    ],
                    'json' => $transfer->toJSON(),
                ]
            );

        } catch (\Exception $e) {

        }

        $tmp = (object)$this->getContent($response);

        $tdf = new TransferDataForm;
        $tdf->setData($tmp->data);
        $tdf->setType($tmp->type);
        return $tdf;
    }

    public function twiceEncryptedPermission(TransferDataForm $transfer): TransferDataForm
    {

        try {
            $response = $this->client->request(
                'POST',
                "$this->url/cryptolib/server/twiceEncryptedPermission",
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'X-API-VERSION' => '0.0.3'
                    ],
                    'json' => $transfer->toJSON(),
                ]
            );

        } catch (\Exception $e) {

        }

        $tmp = (object)$this->getContent($response);

        $tdf = new TransferDataForm;
        $tdf->setData($tmp->data);
        $tdf->setType($tmp->type);
        return $tdf;
    }

    public function dataRequest(TransferDataForm $transfer): TransferDataForm
    {
        try {
            $response = $this->client->request(
                'POST',
                "$this->url/cryptolib/server/dataRequest",
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'X-API-VERSION' => '0.0.3'
                    ],
                    'json' => $transfer->toJSON(),
                ]
            );

        } catch (\Exception $e) {

        }
        $tmp = (object)$this->getContent($response);

        $tdf = new TransferDataForm;
        $tdf->setData($tmp->data);
        $tdf->setType($tmp->type);
        return $tdf;
    }


    public function encryptedDataRequestV1($trustedDeviceData, TransferDataForm $transfer): TransferDataForm
    {
        try {
            $response = $this->client->request(
                'POST',
                "$this->url/cryptolib/server/encryptedDataRequest/v1/$trustedDeviceData",
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'X-API-VERSION' => '0.0.3'
                    ],
                    'json' => $transfer->toJSON(),
                ]
            );

        } catch (\Exception $e) {

        }
        $tmp = (object)$this->getContent($response);

        $tdf = new TransferDataForm;
        $tdf->setData($tmp->data);
        $tdf->setType($tmp->type);
        return $tdf;
    }


    public function autoTest()
    {

        $resetTD = (object)[
            "id" => 1,
            "deviceActualKey" => "r7rJgnzgjIs=",
            "deviceOldKey" => "r7rJgnzgjIs=",
            "devicePublicId" => "001-0000-0000001-7",
            "deviceFactoryKey" => "AAAAAAAAAAA=",
            "devicePrivateId" => "AAAAAAAB28E=",
        ];

        try {
            $this->client->request(
                'POST',
                "http://81.200.255.34:8080/cryptographic/trusted_devices/update",
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'X-API-VERSION' => '0.0.3'
                    ],
                    'json' => $resetTD,
                ]
            );

        } catch (\Exception $e) {

        }


        $resetTD = (object)[
            "id" => 2,
            "deviceActualKey" => "S6ULRaPVajA=",
            "deviceOldKey" => "S6ULRaPVajA=",
            "devicePublicId" => "001-0000-0000002-5",
            "deviceFactoryKey" => "AAAAAAAAAAA=",
            "devicePrivateId" => "AAAAAAAC2oE=",
        ];

        try {
            $response = $this->client->request(
                'POST',
                "http://81.200.255.34:8080/cryptographic/trusted_devices/update",
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'X-API-VERSION' => '0.0.3'
                    ],
                    'json' => $resetTD,
                ]
            );

        } catch (\Exception $e) {

        }

        $settingList = [
            (object)["key" => "serverUserId", "value" => "680a1958-8fab-4852-bc3f-ef36e0ce7dbc"],
            (object)["key" => "serverOauthToken", "value" => ""],
            (object)["key" => "serverToCryptograpicUrl", "value" => "http://10.43.3.34:8080/cryptographic"],
            (object)["key" => "serverTrustedDevicePublicId", "value" => base64_encode("001-0000-0000002-5")],
            (object)["key" => "serverTrustedDevicePrivateId", "value" => "AAAAAAAC2oE="],
            (object)["key" => "serverTrustedDeviceActualKey", "value" => "S6ULRaPVajA="],
            (object)["key" => "serverTrustedDeviceFactoryKey", "value" => "AAAAAAAAAAA="],
            (object)["key" => "serverTrustedDeviceOldKey", "value" => "S6ULRaPVajA="],
            (object)["key" => "serverSelfInit", "value" => "true"],
            (object)["key" => "serverNeedOauth", "value" => "false"],
            (object)["key" => "senderTrustedDeviceActualKey", "value" => "r7rJgnzgjIs="],
        ];

        try {
            $response = $this->client->request(
                'POST',
                "$this->url/cryptolib/server/settings",
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'X-API-VERSION' => '0.0.3'
                    ],
                    'json' => $settingList,
                ]
            );

        } catch (\Exception $e) {

        }

        $transfer = new Transfer;
        $transfer->sender_user_id = "0624f73e-ab24-4f95-a30f-c4cb752aed5d";
        $transfer->recipient_user_id = "680a1958-8fab-4852-bc3f-ef36e0ce7dbc77";
        $transfer->data = "eyJkYXRhIjoiZXlKelpXNWtaWEpVY25WemRHVmtSR1YyYVdObFVIVmliR2xqU1dRaU9pSk5SRUY0VEZSQmQwMUVRWFJOUkVGM1RVUkJkMDFUTURNaUxDSmxibU55ZVhCMFpXUkVZWFJoUlhoamFHRnVaMlZTWlhGMVpYTjBJam9pZVdWVFdXeDFhVzFCVnpkaVRYRlNWekY1T1hreVVVWk9Vek14UW01cE1reEtLekZ0Y1V4R1JGQjBUbXQwYkd4d2NtazFjVXBSVEZJMlIycHJRbmtyYWk4NFZIZFRkblZMTHk5TlBTSjkiLCJ0eXBlIjoxfQ==";
        $transfer->status = (new ErrorForm(0))->toJSON();
        $transfer->save();

        $transferForm = new TransferForm(
            $transfer->id,
            $transfer->sender_user_id,
            $transfer->recipient_user_id,
            $transfer->data,
            $transfer->created_at,
            $transfer->updated_at
        );
        $transferForm->setStatus($transfer->status);

        $userPayloadService = new UserPayloadServiceForServer();
        $userPayloadService->handler($transferForm);

        $testEncryptTranfser = new Transfer;
        $testEncryptTranfser->sender_user_id = "0624f73e-ab24-4f95-a30f-c4cb752aed5d";
        $testEncryptTranfser->recipient_user_id = "680a1958-8fab-4852-bc3f-ef36e0ce7dbc77";

        $tdf = new TransferDataForm;
        $tdf->setData("test data");
        $tdf->setType(7);

        $tdf = $this->encryptedDataRequestV1("AA==", $tdf);

        Log::info(print_r($tdf->toJSON(), true));

        $testEncryptTranfser->data = $tdf->toBase64JSON();
        $testEncryptTranfser->status = (new ErrorForm(0))->toJSON();
        $testEncryptTranfser->save();

        Log::info("Result encrypt=>" . print_r($tdf->toBase64JSON(), true));

        $tdf = new TransferDataForm;
        $tdf->setData($testEncryptTranfser->data);
        $tdf->setType(8);

        $tdf = $this->dataRequest($tdf);

        Log::info("Result decrypt=>" . print_r($tdf->getData(), true));

    }


    public static function routes()
    {
        include_once __DIR__ . '/../routes.php';
    }


}
