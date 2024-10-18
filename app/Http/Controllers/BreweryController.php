<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\BreweryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class BreweryController extends Controller
{

    protected $breweryService;

    public function __construct(BreweryService $breweryService)
    {
        $this->breweryService = $breweryService;
    }

    public function index(Request $request)
    {
        $rules = [
            'page' => 'integer',
            'per_page' => 'integer',
            'brewery_type' => 'string',
            'country' => 'string',
            'city' => 'string',
            'name' => 'string'
        ];

        $messages = [
            'page.integer' => 'The page must be an integer',
            'per_page.integer' => 'The per_page must be an integer',
            'brewery_type.string' => 'The brewery_type must be a string',
            'country.string' => 'The country must be a string',
            'city.string' => 'The city must be a string',
            'name.string' => 'The name must be a string'
        ];

        $validated = $request->validate($rules, $messages);

        if ($validated) {
            $filters = [
                'brewery_type' => $request->input('brewery_type'),
                'country' => $request->input('country'),
                'city' => $request->input('city'),
                'name' => $request->input('name')
            ];
            
            $page = $request->input('page', 1);
            $per_page = $request->input('per_page', 10);

            $response = $this->breweryService->getBreweries($filters, $page, $per_page);

            return response()->json($response);
        }
    }

    public function getAllFilters()
    {
        $filters = $this->breweryService->getAllFilters();

        return response()->json($filters);
    }
}
