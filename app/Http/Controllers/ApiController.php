<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{


    public function gamemodes()
    {
        $gamemodes = \App\Gamemodes::orderBy('id', 'asc')->get();
        return $gamemodes;
    }

    public function tanks()
    {
        $tanks = \App\Tanks::orderBy('tankname', 'asc')->get();
        return $tanks;
    }

    public function records(Request $request, $method = "json")
    {
        if ($method == "json")
            return \GuzzleHttp\json_encode(RecordsController::getBestRecords());
        elseif ($method == "markdown") {
            $gamemodes = \App\Gamemodes::orderBy('id', 'asc')->get();
            return view('tables.recordstableMarkdown', ["allrecords" => RecordsController::getBestRecords(),"gamemodes"=>$gamemodes]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo "lolo";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}