<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('chirps.index', [
            'chirps' => Chirp::with('user')->latest()->paginate(3),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) :RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255'
        ]);

        $request->user()->chirps()->create($validated);

        return redirect(route('chirps.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp): View
    {
        return view('chirps.user', [
            'user' => $chirp->user->name,
            'userchirp' => Chirp::where('user_id', $chirp->user->id)->latest()->paginate(3),
            'totalposts' => Chirp::where('user_id', $chirp->user->id)->count(),
            'createddate' => $chirp->user->created_at->format('M j Y'),
        ]);
    }
    
    public function profileshow($user_id): View
    {
        return view('profileinfo', [
            'userchirp' => Chirp::where('user_id', $user_id)->latest()->paginate(3),
            'totalposts' => Chirp::where('user_id', $user_id)->count(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp): View
    {
        $this->authorize('update', $chirp);

        return view('chirps.edit', [
            'chirp' => $chirp,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        $this->authorize('update', $chirp);

        $validated = $request->validate([
            'message' => 'required|string|max:255'
        ]);

        $chirp->update($validated);

        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        $this->authorize('delete', $chirp);

        $chirp->delete();

        return redirect(route('chirps.index'));
    }

    public function search(Request $request, Chirp $chirp): View
    {
        if($request->search==''){
            return $this->index();
        }else{
            return view('chirps.search', [
                'query' => $request->search,
                'chirps' => Chirp::where('message', 'like', '%'.$request->search.'%')->paginate(10),
                'users' => User::where('name', 'like', '%'.$request->search.'%')->paginate(10),
            ]);
        }
    }
}
