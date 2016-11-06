<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{


    public function gamemodes(){
        $gamemodes = \App\Gamemodes::orderBy('id', 'asc')->get();
        echo $gamemodes;
    }

    public function tanks(){
        $tanks = \App\Tanks::orderBy('tankname', 'asc')->get();
        echo $tanks;
    }

    public function records(){
        $records = DB::select("SELECT * FROM besttanksview");
        /*
 * To easily display them on a page, we want to format the score and make sure that we only have x submissions for x gamemodes in a row
 */
        for ($i = 0; $i < count($records); $i++) {
            $record = $records[$i];


            $record->scorefull = $record->score;
            $links = array($record->link);
            unset($record->link);
            // Records with the same id but different prooflink should be next to each.
            // We simply look ahead if there are other records with the same id behind this one and add the links on them.
            while ($i + 1 < count($records) && $record->record_id == $records[$i + 1]->record_id) {
                array_push($links, $records[$i + 1]->link);
                array_splice($records, $i + 1, 1);
            }

            $record->cssExtra = "";

            //Check if record is a gamemodewinner
            if (isset($gamemodewinnersCssClass[$record->record_id])) {
                $record->cssExtra = $gamemodewinnersCssClass[$record->record_id];
            }


            $record->links = $links;
            //var_dump($record);
        }


        //echo '<pre>'; print_r($records); echo '</pre>';
        //now group this array by tank_id to make it simply to put it in a table.
        $records = collect($records)->groupBy('tank_id');


        echo \GuzzleHttp\json_encode($records);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
