<?php

namespace App\Services\Files;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FileService
{
    public function upload(Request $request)
    {
        $file = $request->file('file');

        if ($file) {
            $content = file_get_contents($file->getRealPath());
            $base64Content = base64_encode($content);
            // Дернуть ручку
            // https://iam.api.cloud.yandex.net/iam/v1/tokens с токеном в теле
            // folderId скопировать из https://console.yandex.cloud/
            $token = '';
            $folderId = '';

            $data = [
                'mimeType' => $file->getMimeType(),
                'languageCodes' => ['ru'],
                'model' => 'page',
                'content' => $base64Content
            ];
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'x-folder-id' => $folderId,
                'x-data-logging-enabled' => 'true',
            ])
                ->withBody(json_encode($data), 'application/json')
                ->post('https://ocr.api.cloud.yandex.net/ocr/v1/recognizeText');
            if ($response->successful()) {
                $responseData = $response->json();

                return $responseData['result']['textAnnotation']['fullText'];
            } else {
                throw new \Exception(
                    "Error during OCR request. Status: {$response->status()}, " .
                        "Response Body: {$response->body()}, " .
                        "Error Details: " . json_encode($response->json())
                );
            }
        }
    }
}
