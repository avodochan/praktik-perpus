<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $member = Member::all();
        return view('admin.member.index', compact('member'));
    }
    public function koordinatorview()
    {
        $member = Member::all();
        return view('koordinator.member.index', compact('member'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(member $member)
    {
        // dd($member);
        return view ('admin.member.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, member $member)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'no_tlp' => 'required',
        ]);

        $member->update($request->all());
        $user = auth()->user();
        if ($user->role == 'koordinator') {
            $member = Member::all();
            return redirect()->route('koordinator.member.view')
                ->with('success', 'Member berhasil diperbarui.');
        } elseif ($user->role == 'admin') {
            $member = Member::all();
            return redirect()->route('admin.member.view')
                ->with('success', 'Member berhasil diperbarui.');
        }    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(member $member)
    {
        $member->delete();
        $user = auth()->user();
        if ($user->role == 'koordinator') {
            $member = Member::all();
            return redirect()->route('koordinator.member.view')
                ->with('success', 'Member berhasil dihapus.');
        } elseif ($user->role == 'admin') {
            $member = Member::all();
            return redirect()->route('admin.member.view')
                ->with('success', 'Member berhasil dihapus.');
        }
    }
}
