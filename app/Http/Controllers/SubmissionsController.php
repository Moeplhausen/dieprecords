<?php

namespace App\Http\Controllers;

use App\Proofs;
use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Validator;

class SubmissionsController extends Controller
{
    public function show(){
        $submissions=DB::select("
SELECT proofs.id, 
       records.name, 
       records.score, 
       tanks.id       AS tank_id, 
       tanks.tankname, 
       gamemodes.NAME AS gamemode, 
       proofs.proof_link 
FROM   records 
       INNER JOIN tanks 
               ON tanks.id = tank_id 
       INNER JOIN proofs 
               ON records.id = proofs.id 
       INNER JOIN gamemodes 
               ON gamemodes.id = records.gamemode_id 
WHERE  proofs.approved = '0' 
       AND proofs.decided = '0' ");


        return view('submissions',['submissions'=>$submissions]);
    }

    public function decide(Request $request){


        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'answ' => 'boolean',
            'id' => 'integer'
        ]);

        if ($validator->fails()) {
            return response()->json(array('msg'=> 'something went wrong','err'=>$validator->messages()->toJson(),'input'=>$input), 200);
        }

        $proof=Proofs::find($request->input('id'));

        if ($proof==null)
        {
            return response()->json(array('msg'=> 'Record not found'), 200);
        }

        DB::transaction(function () use ($proof,$request){
            $proof->approved=$request->input('answ');
            $proof->decided=true;
            $proof->save();
        });




        $msg = "Successfully changed recoed";
        return response()->json(array('msg'=> $msg,'input'=>$input), 200);


    }


}
