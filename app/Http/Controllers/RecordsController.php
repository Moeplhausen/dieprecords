<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Tanks;
use App\Gamemodes;
use App\Proofs;
use App\Record;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

use App\Http\Requests;

class RecordsController extends Controller
{
    /**
     * This function returns the default records view.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {

        //we need all tank names and ids to show them in the form where to submit a new score
        $tanks = \App\Tanks::orderBy('tankname', 'asc')->get();

        $records = '';

        //Non managers don't need up to date records.
        // So the highscore will be cached for 60minutes for them. This should decrease cpu cycles by a great deal.
        if (Auth::guest()) {
            $records = Cache::remember('records', 60, function () {
                return $this->recordsFetcher();
            });
        } else { //Managers need up to date records
            $records = $this->recordsFetcher();
        }

        //get all gamemodes for the form
        $gamemodes = \App\Gamemodes::orderBy('id', 'asc')->get();

        return view('records', ["tanknames" => $tanks, "allrecords" => $records, 'gamemodes' => $gamemodes]);
    }

    /**
     * This function returns the tank with the highest score by tank class and gamemode
     * @return Records
     */
    private function recordsFetcher()
    {
        /*General idea: Get all scores and join them with proofs to get only approved ones.
        Then get the max score by grouping tank_id and gamemode_id.
        Afterwards we join the result with scores again to get the other collumns of the record (like the id of the record).
        Now we only join them with the other tables to get infos like the actual name of the tank, gamemode and proof-link
        */
        $records = DB::select("
SELECT DISTINCT sortedrecords.name, 
                sortedrecords.score, 
                sortedrecords.tank_id, 
                tanks.tankname, 
                sortedrecords.gamemode_id, 
                gamemodes.name    AS gamemode, 
                proofs.proof_link AS link 
FROM   (SELECT record.* 
        FROM   records record 
               INNER JOIN (SELECT gamemode_id, 
                                  tank_id, 
                                  Max(score) AS score 
                           FROM   records 
                                  INNER JOIN proofs 
                                          ON records.id = proofs.id 
                           WHERE  proofs.approved = '1' 
                           GROUP  BY tank_id, 
                                     gamemode_id) grouprecord 
                       ON record.gamemode_id = grouprecord.gamemode_id 
                          AND record.tank_id = grouprecord.tank_id 
                          AND record.score = grouprecord.score) AS sortedrecords 
       INNER JOIN gamemodes 
               ON sortedrecords.gamemode_id = gamemodes.id 
       INNER JOIN tanks 
               ON sortedrecords.tank_id = tanks.id 
       INNER JOIN proofs 
               ON sortedrecords.proof_id = proofs.id 
ORDER  BY tank_id, 
          gamemode_id");
        //Format scores to shorten them
        foreach ($records as $record) {
            $record->scorefull = $record->score;
            $record->score = $this->thousandsCurrencyFormat($record->score);
        }
        //echo '<pre>'; print_r($records); echo '</pre>';
        //now group this array by tank_id to make it simply to put it in a table.
        return collect($records)->groupBy('tank_id');
    }


    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'inputname' => 'required|max:255',
            'selectclass' => 'required|integer|max:100',
            'score' => 'required|integer|between:0,999999999',
            'proof' => [
                'required',
                'url',
                'regex:~^(?:https?://)(?:www\.)?(?:youtube\.com|youtu\.be|cdn\.discordapp\.com|i\.redd\.it|i\.imgur\.com)(?:/watch\?v=([^&]+)|.*.png|.*.jpg)~x'
            ]//In theory also the youtube ending will also be accepted for the other sites. Shouldn't be a problem though.
        ]);




        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }
        $request->proof=str_replace("http://","https://",$request->proof);
        //make sure the tank actually exists and not just believe the user
        $tank = Tanks::where('id', '=', $request->selectclass)->get();
        //same with gamemode
        $gamemode = Gamemodes::where('id', '=', $request->gamemode_id)->get();

        if ($gamemode->isEmpty() || $tank->isEmpty())
            return redirect('/');

        $tankinfo = $tank[0];
        $gamemodeinfo = $gamemode[0];


        //get current record for this tank and gamemode
        $matchThese = [
            'proofs.approved' => '1',
            'records.tank_id' => $tankinfo->id,
            'records.gamemode_id' => $gamemodeinfo->id];
        $currentbestone = DB::table('records')->join('proofs', 'records.id', '=', 'proofs.id')->select('*')->where($matchThese)->max('score');

        //Deny if current record is higher if exists
        if ($currentbestone && $currentbestone > $request->score)
            return redirect('/')->with('status', [(object)['status' => 'alert-warning', 'message' => "Sorry but the current record for $tankinfo->tankname on $gamemodeinfo->name is $currentbestone which is higher than $request->score."]]);


        //The case that there are two undecided submissions with the same score,gamemode,tank must be prevented (should never happen anyway)
        //get current record for this tank and gamemode
        $matchThese = [
            'proofs.decided' => '0',
            'records.tank_id' => $tankinfo->id,
            'records.gamemode_id' => $gamemodeinfo->id,
            'records.score' => $request->score];
        $samescore = DB::table('records')->join('proofs', 'records.id', '=', 'proofs.id')->select('*')->where($matchThese)->get();
        if (!$samescore->isEmpty()) {
            $name = $samescore[0]->name;
            return redirect('/')->with('status', [(object)['status' => 'alert-warning', 'message' => "Sorry but there already is an undecided submission from $name for the same score "]]);
        }


        //Everything seems fine, let us add them
        DB::transaction(function () use ($request) {
            $proof = new Proofs();
            $proof->proof_link = $request->proof;
            $proof->approved = false;
            $proof->save();

            $record = new Record();
            $record->name = $request->inputname;
            $record->score = $request->score;
            $record->tank_id = $request->selectclass;
            $record->gamemode_id = $request->gamemode_id;
            $record->proof_id = $proof->id;
            $record->ip_address = $request->ip();
            $record->save();
        });

        return redirect('/')->with('status', [(object)['status' => 'alert-success', 'message' => 'Your submission will be handled shortly.', $currentbestone]]);
    }


    // http://stackoverflow.com/questions/4371059/shorten-long-numbers-to-k-m-b
    function thousandsCurrencyFormat($number, $precision = 2, $divisors = null)
    {

        // Setup default $divisors if not provided
        if (!isset($divisors)) {
            $divisors = array(
                pow(1000, 0) => '', // 1000^0 == 1
                pow(1000, 1) => 'K', // Thousand
                pow(1000, 2) => 'M', // Million
                pow(1000, 3) => 'B', // Billion
                pow(1000, 4) => 'T', // Trillion
                pow(1000, 5) => 'Qa', // Quadrillion
                pow(1000, 6) => 'Qi', // Quintillion
            );
        }

        // Loop through each $divisor and find the
        // lowest amount that matches
        foreach ($divisors as $divisor => $shorthand) {
            if ($number < ($divisor * 1000)) {
                // We found a match!
                break;
            }
        }

        // We found our match, or there were no matches.
        // Either way, use the last defined value for $divisor.
        return number_format($number / $divisor, $precision) . $shorthand;
    }


}
