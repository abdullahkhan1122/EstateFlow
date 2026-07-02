<?php

namespace App\Http\Controllers;

use App\Services\EstateFlowRagAssistant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function __invoke(Request $request, EstateFlowRagAssistant $assistant): JsonResponse
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
            'history' => ['sometimes', 'array', 'max:10'],
            'history.*.role' => ['required_with:history', 'in:user,assistant'],
            'history.*.text' => ['required_with:history', 'string', 'max:1000'],
        ]);

        return response()->json($assistant->answer($data['message'], $data['history'] ?? []));
    }
}
