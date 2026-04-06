<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function create()
    {
        return view('applications.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'organization_name' => ['required', 'string', 'max:255'],
            'business_location' => ['required', 'string', 'max:255'],
            'business_activity' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:50'],
            'capital_range' => ['required', 'string', 'in:10M-100M,100M-1B,1B and above'],
            'category' => ['required', 'string', 'in:Government,Private,Public,Small Entrepreneurs'],
        ]);

        Application::create($data);

        return back()->with('success', 'Your application has been submitted successfully. Thank you!');
    }

    public function dashboard()
    {
        $categoryCounts = Application::selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category')
            ->all();

        $capitalCounts = Application::selectRaw('capital_range, count(*) as count')
            ->groupBy('capital_range')
            ->pluck('count', 'capital_range')
            ->all();

        $totalApplications = Application::count();

        return view('dashboard', compact('categoryCounts', 'capitalCounts', 'totalApplications'));
    }

    public function index(Request $request)
    {
        $search = $request->query('search', '');

        $applications = Application::when($search, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('organization_name', 'like', "%{$search}%")
                    ->orWhere('business_location', 'like', "%{$search}%")
                    ->orWhere('business_activity', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        })
        ->orderByDesc('created_at')
        ->paginate(10)
        ->withQueryString();

        return view('applications.index', compact('applications', 'search'));
    }

    public function show(Application $application)
    {
        return view('applications.show', compact('application'));
    }
}
