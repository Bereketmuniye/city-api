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
        if (empty(self::$cities)) {
            self::$cities = [
                1 => new City(1, 'Addis Ababa', 'Ethiopia', 8336817, 'The most populous city in the United States'),
                2 => new City(2, 'Bahir Dar', 'Ethiopia', 8982000, 'The second most populous city in Ethiopia'),
                3 => new City(3, 'Gondar', 'Ethiopia', 13929286, 'The third most populous city in Ethiopia'),
            ];
            self::$nextId = 4;
        }
    }
 
    public function index(): JsonResponse
    {
        $citiesArray = array_map(fn($city) => $city->toArray(), self::$cities);
        return response()->json([
            'success' => true,
            'data' => array_values($citiesArray),
        ]);
    }

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

