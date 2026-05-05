<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Rules\MaxPlansPerDuration;
use DB;
use Illuminate\Http\Request;
use Log;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        // Validate input data
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:plans',
            'stripe_plan' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'duration' => ['required', 'in:mon,yr', new MaxPlansPerDuration($request->duration)],
            'subtitle' => 'nullable|string|max:255',
            'offer_text' => 'nullable|string|max:255',
            'included_title' => 'nullable|string|max:255',
            'features' => 'nullable|array',
            'features.*' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            // Create the plan
            $plan = Plan::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'stripe_plan' => $request->stripe_plan,
                'price' => $request->price,
                'description' => $request->description,
                'duration' => $request->duration,
                'subtitle' => $request->subtitle,
                'offer_text' => $request->offer_text,
                'included_title' => $request->included_title,
            ]);

            // Create associated features if any
            if ($request->has('features')) {
                foreach ($request->features as $feature) {
                    $plan->features()->create(['feature' => $feature]);
                }
            }
        });

        return redirect()->route('plans.index')->with('success', 'Plan created successfully.');
    }


    public function update(Request $request, $id)
    {
        $plan = Plan::with('features')->findOrFail($id);

        // Validate input data
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => "required|string|max:255|unique:plans,slug,{$plan->id}",
            'stripe_plan' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'duration' => ['required', 'in:mon,yr', new MaxPlansPerDuration($request->duration, $plan->id)],
            'subtitle' => 'nullable|string|max:255',
            'offer_text' => 'nullable|string|max:255',
            'included_title' => 'nullable|string|max:255',
            'features' => 'nullable|array',
            'features.*' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request, $plan) {
            // Update the plan
            $plan->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'stripe_plan' => $request->stripe_plan,
                'price' => $request->price,
                'description' => $request->description,
                'duration' => $request->duration,
                'subtitle' => $request->subtitle,
                'offer_text' => $request->offer_text,
                'included_title' => $request->included_title,
            ]);

            // Sync features
            // Delete existing features
            $plan->features()->delete();

            // Create new features
            if ($request->has('features')) {
                foreach ($request->features as $feature) {
                    $plan->features()->create(['feature' => $feature]);
                }
            }
        });

        return redirect()->route('plans.index')->with('success', 'Plan updated successfully.');
    }

    public function show(Plan $plan)
    {
        return '$plan->id';
    }


    public function edit($id)
    {
        $plan = Plan::findOrFail($id);
        return view('admin.plans.create', compact('plan'));
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();

        return redirect()->route('plans.index')->with('success', 'Plan deleted successfully.');
    }
}
