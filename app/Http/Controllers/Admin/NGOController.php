<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class NGOController extends Controller
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
        $ngos = User::where('role', 'ngo')->get();
        return view('admin.ngos.index', compact('ngos'));
    }    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('admin.ngos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'address' => 'required|string',
            'phone_number' => 'required|string|max:20',
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'ngo',
            'address' => $request->address,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('admin.ngos.index')
            ->with('success', 'NGO created successfully');
    }    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id): View
    {
        $ngo = User::where('role', 'ngo')->findOrFail($id);
        return view('admin.ngos.show', compact('ngo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id): View
    {
        $ngo = User::where('role', 'ngo')->findOrFail($id);
        return view('admin.ngos.edit', compact('ngo'));
    }    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $ngo = User::where('role', 'ngo')->findOrFail($id);
        
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id . ',user_id',
            'address' => 'required|string',
            'phone_number' => 'required|string|max:20',
        ]);

        $ngo->update([
            'username' => $request->username,
            'email' => $request->email,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8',
            ]);
            
            $ngo->update([
                'password' => bcrypt($request->password),
            ]);
        }

        return redirect()->route('admin.ngos.index')
            ->with('success', 'NGO updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $ngo = User::where('role', 'ngo')->findOrFail($id);
        $ngo->delete();

        return redirect()->route('admin.ngos.index')
            ->with('success', 'NGO deleted successfully');
    }
}
