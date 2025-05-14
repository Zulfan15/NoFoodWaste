<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DonationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $donations = Donation::with(['donor', 'claim.user'])->get();
        return view('admin.donations.index', compact('donations'));
    }/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('admin.donations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'food_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'pickup_location' => 'required|string',
            'expiration_date' => 'required|date|after:now',
            'user_id' => 'required|exists:users,user_id',
            'status' => 'required|in:available,claimed,expired',
        ]);

        Donation::create([
            'food_name' => $request->food_name,
            'quantity' => $request->quantity,
            'pickup_location' => $request->pickup_location,
            'expiration_date' => $request->expiration_date,
            'user_id' => $request->user_id,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.donations.index')
            ->with('success', 'Donation created successfully');
    }    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id): View
    {
        $donation = Donation::with(['donor', 'claim.user'])->findOrFail($id);
        return view('admin.donations.show', compact('donation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id): View
    {
        $donation = Donation::findOrFail($id);
        return view('admin.donations.edit', compact('donation'));
    }    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $donation = Donation::findOrFail($id);
        
        $request->validate([
            'food_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'pickup_location' => 'required|string',
            'expiration_date' => 'required|date',
            'status' => 'required|in:available,claimed,expired',
        ]);

        $donation->update([
            'food_name' => $request->food_name,
            'quantity' => $request->quantity,
            'pickup_location' => $request->pickup_location,
            'expiration_date' => $request->expiration_date,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.donations.index')
            ->with('success', 'Donation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $donation = Donation::findOrFail($id);
        $donation->delete();

        return redirect()->route('admin.donations.index')
            ->with('success', 'Donation deleted successfully');
    }
}
