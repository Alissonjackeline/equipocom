<?php

namespace App\Http\Controllers;

use App\Models\Jefes;
use Illuminate\Http\Request;

class JefesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view(view: 'jefes.index');
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
    public function show(Jefes $jefes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jefes $jefes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jefes $jefes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jefes $jefes)
    {
        //
    }
}