<?php

namespace App\Http\Controllers;

use App\Http\Requests\B24ContactRequest;
use App\Services\B24\B24ContactService;
use App\Services\B24\B24DealService;
use Illuminate\Http\JsonResponse;

class B24ContactController extends Controller
{
    public function __construct(
        private readonly B24ContactService $b24ContactService,
        private readonly B24DealService    $b24DealService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(B24ContactRequest $request): JsonResponse
    {
        $contactIds = $this->b24DealService->getDealContactIds($request->get('deal_id'));
        $this->b24ContactService->synchronizeContactsData($contactIds);

        return response()->json($this->b24ContactService->getActualContacts($contactIds));
    }
}
