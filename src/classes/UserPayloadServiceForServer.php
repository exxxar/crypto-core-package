<?php


namespace Cryptolib\CryptoCore\Classes;

use Cryptolib\CryptoCore\forms\EncryptedDataForm;
use Cryptolib\CryptoCore\forms\ErrorForm;
use Cryptolib\CryptoCore\forms\HandlerResultForm;
use Cryptolib\CryptoCore\forms\PackedDataForm;
use Cryptolib\CryptoCore\forms\PayloadDataForm;
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

    public function handler(TransferForm $transfer, String $trustedDevicePublicId = null): HandlerResultForm
    {
        if (config("crypto.is_multiconnect") )
            $trustedDevicePublicId = base64_encode($trustedDevicePublicId);


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

        Log::info("handler=>" . print_r($content, true));

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
        $payload = $content->payload ?? null;

        $hrf->setIncomingTransfer($incomingTransfer);
        $hrf->setOutgoingTransfer($outgoingTransfer);
        $hrf->setData($data);
        $hrf->setPayload($payload);

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

    public function encryptData(EncryptedDataForm $transfer, String $trustedDevicePublicId = null): String
    {
        if (config("crypto.is_multiconnect") )
            $trustedDevicePublicId = base64_encode($trustedDevicePublicId);

        try {
            $response = $this->client->request(
                'POST',
                "$this->url/cryptolib/server/encryptedDataRequest",
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
        return base64_encode(json_encode($this->getContent($response)));
    }

    public function decryptData(TransferForm $transfer, String $trustedDevicePublicId = null): PayloadDataForm
    {
        if (config("crypto.is_multiconnect"))
            $trustedDevicePublicId = base64_encode($trustedDevicePublicId);

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

        Log::info("decryptData=>" . print_r($tmp->data, true));

        $tdf = new TransferDataForm;
        $tdf->setData($tmp->data);
        $tdf->setType($tmp->type);

        $payload = json_decode($tdf->getData());

        $pdf = new PayloadDataForm;
        $pdf->setTransferDataForm($tdf);
        $pdf->setTrustedDeviceData($payload->trustedDeviceData);
        $pdf->setUserData($payload->userData);

        return $pdf;
    }

    public function decryptTest()
    {

        $transfer = new Transfer;
        $transfer->sender_user_id = "0624f73e-ab24-4f95-a30f-c4cb752aed5d";
        $transfer->recipient_user_id = "680a1958-8fab-4852-bc3f-ef36e0ce7dbc77";
        $transfer->data = "eyJkYXRhIjoiQzRQdDlXY1N4KytJa0NwQVZOUTVpRHV1MHdIQ2hlOVBUa3BTRzAzRFlOU2JJejJ2b1hsNUg3T1VlTXNVMzlqOS9tR0hzQ0tLT1JtVjUzR25Zdmh3bEdPUVFpUjgxdytVMWpreXRYaG5TTTQwZXNnV3pFYWtoUStKQ1hScUhSOXBsZVVSTWVVdmVqMzNCenJoT211Qit2NFB3Q2thYjYza3podnhFRXNXblUzVlNFR1dXTHBWM1FJMWF2ayt1M3VQUVdEN0psTTA2Uk1IZmxaQjB4KzZ4dz09IiwidHlwZSI6OH0=";
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

        $tdf = $this->decryptData($transferForm);

        Log::info("Result user decrypt=>" . print_r($tdf->getUserData(), true));
        Log::info("Result trusted device decrypt=>" . print_r($tdf->getTrustedDeviceData(), true));
    }

    public function encryptTest()
    {


        $edf = new EncryptedDataForm();

        $edf->setPackedDataForm(new PackedDataForm(1, true));

        $edf->setType(7);

        Log::info(print_r($edf->toJson(), true));


        $base64EncodedData = $this->encryptData($edf);

        Log::info(print_r($base64EncodedData, true));

        $transfer = new Transfer;
        $transfer->sender_user_id = "0624f73e-ab24-4f95-a30f-c4cb752aed5d";
        $transfer->recipient_user_id = "680a1958-8fab-4852-bc3f-ef36e0ce7dbc77";
        $transfer->data = $base64EncodedData;
        $transfer->status = (new ErrorForm(0))->toJSON();
        $transfer->save();


        Log::info("Result data encrypt=>" . print_r($transfer->data, true));
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
                'PUT',
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
            "deviceActualKey" => "o18lnjUP5KA=",
            "deviceOldKey" => "o18lnjUP5KA=",
            "devicePublicId" => "001-0001-0000000-8",
            "deviceFactoryKey" => "o18lnjUP5KA=",
            "devicePrivateId" => "AEAAAAAA1AE=",
        ];

        try {
            $response = $this->client->request(
                'PUT',
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
            (object)["key" => "serverTrustedDevicePublicId", "value" => base64_encode("001-0001-0000000-8")],
            (object)["key" => "serverTrustedDevicePrivateId", "value" => "AEAAAAAA1AE="],
            (object)["key" => "serverTrustedDeviceActualKey", "value" => "o18lnjUP5KA="],
            (object)["key" => "serverTrustedDeviceFactoryKey", "value" => "o18lnjUP5KA="],
            (object)["key" => "serverTrustedDeviceOldKey", "value" => "o18lnjUP5KA="],
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
        $transfer->data = "eyJ0eXBlIjoxLCJkYXRhIjoiZXlKelpXNWtaWEpVY25WemRHVmtSR1YyYVdObFVIVmliR2xqU1dRaU9pSk5SRUY0VEZSQmQwMUVSWFJOUkVGM1RVUkJkMDFUTURJaUxDSmxibU55ZVhCMFpXUkVZWFJoUlhoamFHRnVaMlZTWlhGMVpYTjBJam9pUmpRek1URTBTRmR2V20weFJGSXlVa3A2YUdkdVpYUm5SMk40UjBGeFltUnRkVVJrVHpWQ04wbEtPVFpwYkU5aWJteFFSRFpvVnpoVFVtOWljbXBDTmxWVlZtYzJaRGg2Um1nMFBTSjkifQ==";
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

        $tdf = $this->encryptData("AA==", $tdf);

        Log::info(print_r($tdf->toJSON(), true));

        $testEncryptTranfser->data = json_encode($tdf->toJSON());
        $testEncryptTranfser->status = (new ErrorForm(0))->toJSON();
        $testEncryptTranfser->save();

        Log::info("Result encrypt=>" . print_r($tdf->toJSON(), true));

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
