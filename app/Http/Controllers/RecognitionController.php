<?php

namespace App\Http\Controllers;

use App\Services\Files\FileService;
use Exception;
use Illuminate\Http\Request;

class RecognitionController extends Controller
{

    public function __construct(private FileService $fileService) {}

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $text = $this->fileService->upload($request);

            return response()->json([
                "success" => true,
                "text" => $text
            ]);
        } catch (Exception $e) {
            return response()->json([
                "msg" => $e->getMessage(),
                "code" => $e->getCode()
            ]);
        }
    }
}
