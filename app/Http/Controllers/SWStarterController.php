<?php

namespace App\Http\Controllers;

use App\Services\SWAPIService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SWStarterController extends Controller
{
    /**
     * Index page for SWStarter
     */
    public function index(Request $request)
    {
        $search = $request->query('search') ?? '';
        $type = ($request->query('type') ?? 'people');
        $resultData = [];

        if (strlen($search)) {
            $swapiService = new SWAPIService();
            $resultData = $swapiService->search($type, $search);
        }

        return Inertia::render('SWStarter/Index', [
            'search' => $search,
            'resultType' => $type,
            'resultData' => $resultData
        ]);
    }

    /**
     * Show page for SWStarter
     */
    public function show(Request $request)
    {
        $url = $request->query('url');
        $type = $request->query('type') ?? 'people';

        $swapiService = new SWAPIService();
        $response = $swapiService->getSWModel($type, $url);

        return Inertia::render('SWStarter/Show', [
            'details' => $response,
            'type' => $type
        ]);
    }
}
