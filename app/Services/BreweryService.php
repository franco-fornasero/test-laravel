<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;


class BreweryService
{
    public function getBreweries($filters, $page, $perPage)
    {
        // First, we will check if the breweries are already cached
        $breweries = cache()->remember('breweries', 60 * 60 * 12, function () {
            $response = Http::get('https://api.openbrewerydb.org/v1/breweries');
            return $response->json();
        });

        // Convert to collection
        $breweries = collect($breweries);

        // Apply filters
        $filteredBreweries = $this->applyFilters($breweries, $filters);

        // Paginate the results
        $paginatedBreweries = $this->paginate($filteredBreweries, $page, $perPage);

        return $paginatedBreweries;
    }

    public function applyFilters($breweries, $filters)
    {
        if (isset($filters['brewery_type'])) {
            $breweries = $breweries->where('brewery_type', $filters['brewery_type']);
        }

        if (isset($filters['country'])) {
            $breweries = $breweries->where('country', $filters['country']);
        }

        if (isset($filters['city'])) {
            $breweries = $breweries->where('city', $filters['city']);
        }

        if (isset($filters['name'])) {
            $breweries = $breweries->filter(function ($brewery) use ($filters) {
                return str_contains(strtolower($brewery['name']), strtolower($filters['name']));
            });
        }

        return $breweries;
    }

    public function paginate($breweries, $page, $per_page)
    {
        $total_items = count($breweries);
        $last_page = ceil($total_items / $per_page);

        $breweries = collect($breweries)->forPage($page, $per_page)->values();

        // Return the paginated data
        return [
            'data' => $breweries,
            'meta' => [
                'total_items' => intval($total_items),
                'last_page' => intval($last_page),
                'current_page' => intval($page),
                'per_page' => intval($per_page)
            ]
        ];
    }

    public function getAllFilters()
    {
        
        $cacheKey = 'all_filters'; 

        // Check if the filters are already cached, if not, fetch them from the API and cache them for 12 hours
        $filters = cache()->remember($cacheKey, 60 * 60 * 12, function () {

            // Fetch the breweries from cache, if not available, fetch them from the API
            $breweries = cache()->remember('breweries', 60 * 60 * 12, function () {
                $response = Http::get('https://api.openbrewerydb.org/v1/breweries');
                return $response->json();
            });

            //convert to collection
            $breweries = collect($breweries);

            //get unique values and sort them
            $brewery_types = $breweries->pluck('brewery_type')->unique()->sort()->values();
            $countries = $breweries->pluck('country')->unique()->sort()->values();
            $cities = $breweries->pluck('city')->unique()->sort()->values();

            return [
                'brewery_types' => $brewery_types,
                'countries' => $countries,
                'cities' => $cities,
            ];
        });

        return $filters;
    }
}
