<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Offer;
use App\Models\Project;
use App\Models\Customer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /**
     * Display a listing of offers
     */
    public function index()
    {
        $offers = Offer::with(['customer', 'project', 'createdBy'])
                      ->orderBy('created_at', 'desc')
                      ->paginate(15);

        return view('admin.offers.index', compact('offers'));
    }

    /**
     * Show the form for creating a new offer
     */
    public function create(Request $request)
    {
        $customers = Customer::where('status', 'active')->orderBy('name')->get();
        $projects = Project::where('status', 'active')->orderBy('name')->get();
        
        $selectedProject = null;
        if ($request->has('project_id')) {
            $selectedProject = Project::find($request->project_id);
        }

        return view('admin.offer.admin_offers_create', compact('customers', 'projects', 'selectedProject'));
    }

    /**
     * Store a newly created offer
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'customer_id' => 'required|exists:customers,id',
            'project_id' => 'nullable|exists:projects,id',
            'valid_until' => 'nullable|date|after:today',
            'currency' => 'nullable|string|in:CHF,EUR,USD,GBP',
            'notes' => 'nullable|string',
        ]);

        $offer = Offer::create([
            'name' => $request->name,
            'description' => $request->description,
            'customer_id' => $request->customer_id,
            'project_id' => $request->project_id,
            'valid_until' => $request->valid_until,
            'notes' => $request->notes,
            'created_by_user_id' => Auth::id(),
            'status' => 'draft',
            'price' => 0.00, // Will be calculated from items
            'currency' => $request->currency ?? 'CHF', // Default to CHF
        ]);

        return redirect()->route('admin.offer.admin_offers_show', $offer)
                        ->with('success', 'Offer created successfully!');
    }

    /**
     * Display the specified offer
     */
    public function show(Offer $offer)
    {
        $offer->load(['customer', 'project', 'createdBy', 'items']);
        
        return view('admin.offer.admin_offers_show', compact('offer'));
    }

    /**
     * Show the form for editing the specified offer
     */
    public function edit(Offer $offer)
    {
        $customers = Customer::where('status', 'active')->orderBy('name')->get();
        $projects = Project::where('status', 'active')->orderBy('name')->get();

        return view('admin.offers.edit', compact('offer', 'customers', 'projects'));
    }

    /**
     * Update the specified offer
     */
    public function update(Request $request, Offer $offer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'customer_id' => 'required|exists:customers,id',
            'project_id' => 'nullable|exists:projects,id',
            'valid_until' => 'nullable|date|after:today',
            'currency' => 'nullable|string|in:CHF,EUR,USD,GBP',
            'notes' => 'nullable|string',
        ]);

        $offer->update($request->only([
            'name', 'description', 'customer_id', 'project_id', 
            'valid_until', 'currency', 'notes'
        ]));

        return redirect()->route('admin.offer.admin_offers_show', $offer)
                        ->with('success', 'Offer updated successfully!');
    }

    /**
     * Remove the specified offer
     */
    public function destroy(Offer $offer)
    {
        $offer->delete();

        return redirect()->route('admin.offers.index')
                        ->with('success', 'Offer deleted successfully!');
    }

    /**
     * Get offers for a specific project (for AJAX/API calls)
     */
    public static function getOffersForProject($project_id)
    {
        $offers = Offer::where('project_id', $project_id)
                      ->with(['customer', 'items'])
                      ->orderBy('created_at', 'desc')
                      ->get();

        return $offers;
    }

    /**
     * Mark offer as sent
     */
    public function markAsSent(Offer $offer)
    {
        $offer->markAsSent();

        return redirect()->back()->with('success', 'Offer marked as sent!');
    }

    /**
     * Mark offer as accepted
     */
    public function markAsAccepted(Offer $offer)
    {
        $offer->markAsAccepted();

        return redirect()->back()->with('success', 'Offer marked as accepted!');
    }

    /**
     * Mark offer as rejected
     */
    public function markAsRejected(Offer $offer)
    {
        $offer->markAsRejected();

        return redirect()->back()->with('success', 'Offer marked as rejected!');
    }

    public static function calculateTotal($project_id)
    {
        $offers = Offer::where('project_id', $project_id)->get();
        $total = 0;
        $primaryCurrency = 'CHF'; // Default currency
        
        foreach ($offers as $offer) {
            $total += $offer->calculateTotal();
            // Use the currency of the first offer as primary currency
            if ($offer->currency) {
                $primaryCurrency = $offer->currency;
            }
        }
        
        // Format with currency symbol
        $currencySymbols = [
            'CHF' => 'CHF',
            'EUR' => '€',
            'USD' => '$',
            'GBP' => '£',
        ];

        $symbol = $currencySymbols[$primaryCurrency] ?? $primaryCurrency;
        
        return $symbol . ' ' . number_format($total, 2);
    }
}
