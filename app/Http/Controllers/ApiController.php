<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{


    public function gamemodes()
    {
        $gamemodes = \App\Gamemodes::orderBy('id', 'asc')->get();
        return \GuzzleHttp\json_encode($gamemodes);
    }

    public function tanks()
    {
        $tanks = \App\Tanks::orderBy('tankname', 'asc')->get();
        return \GuzzleHttp\json_encode($tanks);
    }

    public function records(Request $request, $method = "json")
    {
        if ($method == "json"){
            return \GuzzleHttp\json_encode([
                'desktop'=>RecordsController::getBestRecords(true),
                'mobile'=>RecordsController::getBestRecords(false)]);
        }
        elseif ($method == "markdown") {
            $gamemodesDesktop = \App\Gamemodes::orderBy('id', 'asc')->where(['mobile'=>false])->get();
            $gamemodesMobile = \App\Gamemodes::orderBy('id', 'asc')->where(['mobile'=>true])->get();

            return view('markdown.recordstableMarkdown', [
                "allrecordsDesktop" => RecordsController::getBestRecords(true),
                "allrecordsMobile" => RecordsController::getBestRecords(false),
                "gamemodesDesktop"=>$gamemodesDesktop,
                "gamemodesMobile"=>$gamemodesMobile]);
        }
    }

    public function recordsByName(Request $request,$name="derp"){
        $data=app('App\Http\Controllers\RecordsController')->getRecordsByName($name);

        return \GuzzleHttp\json_encode([
           'current'=>$data['current'],
            'former'=>$data['former']
        ]);
    }

    public function history(Request $request,$tankid=1,$gamemode=4,$desktop=true){
        $data=app('App\Http\Controllers\RecordsController')->getTankHistory($tankid,$gamemode,$desktop);

        return \GuzzleHttp\json_encode([
            'tankhistory'=>$data,
        ]);
    }


    public function submit(Request $request){

        return app('App\Http\Controllers\RecordsController')->submit($request, true,true);
    }

    public function submittest(Request $request){

        return app('App\Http\Controllers\RecordsController')->submit($request, true,false);
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
