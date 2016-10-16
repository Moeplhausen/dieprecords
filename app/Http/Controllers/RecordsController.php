<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Tanks;
use App\Gamemodes;
use App\Proofs;
use App\Record;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests;

class RecordsController extends Controller
{
    public function show(){

        $tanks = \App\Tanks::orderBy('tankname', 'asc')->get();

        $records = DB::select("
SELECT DISTINCT sortedrecords.NAME, 
                sortedrecords.score, 
                sortedrecords.tank_id, 
                tanks.tankname, 
                sortedrecords.gamemode_id, 
                gamemodes.NAME    AS gamemode, 
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
        //echo "<pre>"; print_r($records);
        foreach ($records as $record) {
            $record->score = $this->thousandsCurrencyFormat($record->score);
        }
        $records = collect($records)->groupBy('tank_id');

        $gamemodes = \App\Gamemodes::orderBy('id', 'asc')->get();
        //echo "<pre>"; print_r($records);

        return view('records', ["tanknames" => $tanks, "allrecords" => $records, 'gamemodes' => $gamemodes]);
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'inputname' => 'required|max:255',
            'selectclass' => 'required|integer|max:100',
            'score' => 'required|integer|between:0,99999999',
            'proof' => 'required|url'
        ]);


        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }

        $tank = Tanks::where('id', '=', $request->selectclass)->get();
        $gamemode = Gamemodes::where('id', '=', $request->gamemode_id)->get();

        if ($gamemode->isEmpty()|| $tank->isEmpty()||!$this->isImageOrYoutube($request->proof))
            return redirect('/');

        DB::transaction(function () use ($request){
            $proof= new Proofs();
            $proof->proof_link=$request->proof;
            $proof->approved=false;
            $proof->save();

            $record=new Record();
            $record->name=$request->inputname;
            $record->score=$request->score;
            $record->tank_id=$request->selectclass;
            $record->gamemode_id=$request->gamemode_id;
            $record->proof_id=$proof->id;
            $record->ip_address=$request->ip();
            $record->save();
        });

        return redirect('/');
    }


    public  function isImageOrYoutube($url)
    {
        $params = array('http' => array(
            'method' => 'HEAD'
        ));
        $ctx = stream_context_create($params);
        $fp = @fopen($url, 'rb', false, $ctx);
        if (!$fp)
            return false;  // Problem with url

        $meta = stream_get_meta_data($fp);
        if ($meta === false)
        {
            fclose($fp);
            return false;  // Problem reading data from url
        }

        $wrapper_data = $meta["wrapper_data"];
        if(is_array($wrapper_data)){
            foreach(array_keys($wrapper_data) as $hh){
                if (substr($wrapper_data[$hh], 0, 19) == "Content-Type: image") // strlen("Content-Type: image") == 19
                {
                    fclose($fp);
                    return true;
                }
            }
        }

        fclose($fp);

        $rx = '~
    ^(?:https?://)?              # Optional protocol
     (?:www\.)?                  # Optional subdomain
     (?:youtube\.com|youtu\.be)  # Mandatory domain name
     /watch\?v=([^&]+)           # URI with video id as capture group 1
     ~x';

        $has_match = preg_match($rx, $url, $matches);
        return $has_match;



    }




//http://stackoverflow.com/a/36365553
    public  function thousandsCurrencyFormat($num)
    {
        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('k', 'm', 'b', 't');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int)$x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];
        return $x_display;
    }



}
