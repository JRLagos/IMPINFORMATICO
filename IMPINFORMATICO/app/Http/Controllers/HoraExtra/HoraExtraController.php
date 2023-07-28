<?php

namespace App\Http\Controllers\HoraExtra;

use Iluminate\Support\Facades\http;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HoraExtraController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index($ACCION, $COD_EMPLEADO)
    { 

        $res = Http::get("http://localhost:3000/SHOW_HORA_EXTRA/$ACCION/$COD_EMPLEADO");

        return view('horaextra.index')->with('$ResulHoraExtra', json_decode($response,true));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
