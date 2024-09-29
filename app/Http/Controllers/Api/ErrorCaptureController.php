<?php

namespace App\Http\Controllers\Api;

use App\Actions\CaptureErrorAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ErrorCaptureRequest;
use App\Models\Project;
use Illuminate\Http\JsonResponse;

class ErrorCaptureController extends Controller
{
    public function __construct(
        private readonly Project $model
    ) {}

    public function __invoke(ErrorCaptureRequest $request): JsonResponse
    {
        $payload = $request->validated();

        dispatch(function () use ($payload) {
            app(CaptureErrorAction::class)->handle($payload);
        })->afterResponse();

        return response()->json([
            'message' => 'success',
        ]);
    }
}
