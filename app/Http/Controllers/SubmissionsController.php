<?php

namespace App\Http\Controllers;

use App\Proofs;
use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubmissionsController extends Controller
{
    public function show()
    {


        //Get all records that aren't approved and haven't been decided by a manager yet.
        $submissions = DB::select("
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


        return view('submissions', ['submissions' => $submissions]);
    }

    /**
     *
     * @param Request $request
     *
     * This is function to handle the ajax request when a manager approves (or not) a record.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function decide(Request $request)
    {


        $input = $request->all();

        //make sure the manager actually sends a request as expected
        $validator = Validator::make($request->all(), [
            'answ' => 'boolean',
            'id' => 'integer'
        ]);

        //complain to user if they sent crap
        if ($validator->fails()) {
            return response()->json(array('msg' => 'something went wrong', 'err' => $validator->messages()->toJson(), 'input' => $input), 200);
        }
        //don't believe the manager to actually send a valid id
        $proof = Proofs::find($request->input('id'));

        if ($proof == null) {
            //complain to user if they sent crap
            return response()->json(array('msg' => 'Record not found'), 200);
        }
        //The proof has been decided and will be aved.
        DB::transaction(function () use ($proof, $request) {
            $proof->approved = $request->input('answ');
            $proof->decided = true;
            $proof->save();
        });


        $msg = 'Successfully changed record. It was approved: ' . ($proof->approved == '1' ? 'true' : 'false');
        return response()->json(array('msg' => $msg, 'input' => $input), 200);


    }


}
