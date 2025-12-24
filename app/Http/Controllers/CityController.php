<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    private static array $cities = [];
    private static int $nextId = 1;

    public function __construct()
    {
        // Initialize with some sample data if empty
        if (empty(self::$cities)) {
            self::$cities = [
                1 => new City(1, 'New York', 'USA', 8336817, 'The most populous city in the United States'),
                2 => new City(2, 'London', 'United Kingdom', 8982000, 'Capital city of England and the United Kingdom'),
                3 => new City(3, 'Tokyo', 'Japan', 13929286, 'Capital city of Japan'),
            ];
            self::$nextId = 4;
        }
    }

    /**
     * Display a listing of all cities.
     */
    public function index(): JsonResponse
    {
        $citiesArray = array_map(fn($city) => $city->toArray(), self::$cities);
        return response()->json([
            'success' => true,
            'data' => array_values($citiesArray),
        ]);
    }

    /**
     * Store a newly created city.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'population' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $id = self::$nextId++;
        $city = new City(
            $id,
            $request->name,
            $request->country,
            $request->population,
            $request->description
        );

        self::$cities[$id] = $city;

        return response()->json([
            'success' => true,
            'message' => 'City created successfully',
            'data' => $city->toArray(),
        ], 201);
    }

    /**
     * Display the specified city.
     */
    public function show(int $id): JsonResponse
    {
        if (!isset(self::$cities[$id])) {
            return response()->json([
                'success' => false,
                'message' => 'City not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => self::$cities[$id]->toArray(),
        ]);
    }

    /**
     * Update the specified city.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        if (!isset(self::$cities[$id])) {
            return response()->json([
                'success' => false,
                'message' => 'City not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'country' => 'sometimes|required|string|max:255',
            'population' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $city = self::$cities[$id];

        if ($request->has('name')) {
            $city->name = $request->name;
        }
        if ($request->has('country')) {
            $city->country = $request->country;
        }
        if ($request->has('population')) {
            $city->population = $request->population;
        }
        if ($request->has('description')) {
            $city->description = $request->description;
        }

        return response()->json([
            'success' => true,
            'message' => 'City updated successfully',
            'data' => $city->toArray(),
        ]);
    }

    /**
     * Remove the specified city.
     */
    public function destroy(int $id): JsonResponse
    {
        if (!isset(self::$cities[$id])) {
            return response()->json([
                'success' => false,
                'message' => 'City not found',
            ], 404);
        }

        unset(self::$cities[$id]);

        return response()->json([
            'success' => true,
            'message' => 'City deleted successfully',
        ]);
    }
}

