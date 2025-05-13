<?php

namespace App\Http\Controllers\NGO;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DonationClaim;
use App\Models\DistributionReport;
use Illuminate\Support\Facades\Auth;

class DistributionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the distribution reports.
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $claims = DonationClaim::where('user_id', Auth::id())
            ->where('status', 'completed')
            ->with('donation.donor')
            ->orderBy('completed_at', 'desc')
            ->get();
            
        return view('ngo.distribution.index', compact('claims'));
    }
    
    /**
     * Show the form for creating a new distribution report.
     *
     * @param  int  $claimId
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse
     */
    public function create($claimId)
    {
        $claim = DonationClaim::where('user_id', Auth::id())
            ->with('donation.donor')
            ->findOrFail($claimId);
            
        if ($claim->distribution_report) {
            return redirect()->route('ngo.distribution-reports')
                ->with('error', 'Distribution report already exists for this claim');
        }
        
        return view('ngo.distribution.create', compact('claim'));
    }
    
    /**
     * Store a newly created distribution report in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $claimId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $claimId)
    {
        $claim = DonationClaim::where('user_id', Auth::id())
            ->findOrFail($claimId);
            
        if ($claim->distribution_report) {
            return redirect()->route('ngo.distribution-reports')
                ->with('error', 'Distribution report already exists for this claim');
        }
        
        $request->validate([
            'recipients_count' => 'required|integer|min:1',
            'distribution_date' => 'required|date',
            'distribution_location' => 'required|string',
            'notes' => 'nullable|string',
            'images.*' => 'nullable|image|max:2048',
        ]);
        
        $distributionReport = new DistributionReport([
            'donation_claim_id' => $claim->id,
            'recipients_count' => $request->recipients_count,
            'distribution_date' => $request->distribution_date,
            'distribution_location' => $request->distribution_location,
            'notes' => $request->notes,
        ]);
        
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('distribution-reports', 'public');
                $imagePaths[] = $path;
            }
            $distributionReport->images = json_encode($imagePaths);
        }
        
        $distributionReport->save();
        
        return redirect()->route('ngo.distribution-reports')
            ->with('success', 'Distribution report created successfully');
    }
    
    /**
     * Display the specified distribution report.
     *
     * @param  int  $reportId
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show($reportId)
    {
        $report = DistributionReport::where('donation_claim.user_id', Auth::id())
            ->with('claim.donation.donor')
            ->findOrFail($reportId);
            
        return view('ngo.distribution.show', compact('report'));
    }
}
