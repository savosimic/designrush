<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ServiceProvider;
use Illuminate\Http\Request;

class ServiceProviderController extends Controller
{
    /**
     * Display a paginated list of providers, optionally filtered by category.
     */
    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        // Base query with eager loading
        $query = ServiceProvider::with('category');

        // Apply category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Build a unique cache key
        $page     = $request->input('page', 1);
        $category = $request->input('category', 'all');
        $cacheKey = "providers_page_{$page}_category_{$category}";

        // Attempt to get from Redis, otherwise run the query and cache it
        $providers = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($query) {
            return $query->orderBy('name')->paginate(10);
        });

        // Always load categories fresh
        $categories = \App\Models\Category::orderBy('name')->get();

        return view('providers.index', compact('providers','categories'));
    }

    /**
     * Display a single provider’s profile.
     */
    public function show(ServiceProvider $provider)
    {
        // $provider already has category loaded via route-model binding
        $provider->load('category');

        return view('providers.show', compact('provider'));
    }
}
