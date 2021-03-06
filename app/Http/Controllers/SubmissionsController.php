<?php

namespace App\Http\Controllers;

use App\Jobs\NotifyDiscordAboutSubmission;
use App\Proofs;
use App\Records;
use App\Names;
use Illuminate\Http\Request;

use App\Http\Requests;
use App;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class SubmissionsController extends Controller
{


    public function show()
    {


        //Get all records that aren't approved and haven't been decided by a manager yet.
        $submissionsDesktop = DB::select("
SELECT proofs.id AS id, 
       proofs.submittedlink as submittedlink,
       names.name AS name,
       records.world_record as world_record,  
       records.score AS score, 
       tanks.id       AS tank_id, 
       tanks.tankname AS tankname, 
       gamemodes.NAME AS gamemode, 
       prooflinks.proof_link AS link
FROM   records 
       INNER JOIN tanks 
               ON tanks.id = tank_id 
       INNER JOIN proofs 
               ON records.id = proofs.id 
       INNER JOIN gamemodes 
               ON gamemodes.id = records.gamemode_id 
       INNER JOIN prooflinks
               ON proofs.id=prooflinks.proof_id
       INNER JOIN names
               ON names.id=records.nameId    
WHERE   proofs.decided = '0'
        AND gamemodes.mobile='0'");
        $submissionsMobile = DB::select("
SELECT proofs.id AS id, 
       proofs.submittedlink as submittedlink,
       names.name AS name,
       records.score AS score,
       records.world_record AS world_record,
       tanks.id       AS tank_id, 
       tanks.tankname AS tankname, 
       gamemodes.NAME AS gamemode, 
       prooflinks.proof_link AS link
FROM   records 
       INNER JOIN tanks 
               ON tanks.id = tank_id 
       INNER JOIN proofs 
               ON records.id = proofs.id 
       INNER JOIN gamemodes 
               ON gamemodes.id = records.gamemode_id 
       INNER JOIN prooflinks
               ON proofs.id=prooflinks.proof_id    
       INNER JOIN names
               ON names.id=records.nameId 
WHERE  proofs.decided = '0'
        AND gamemodes.mobile='1'");
        $submissionsDesktop = collect($submissionsDesktop)->groupBy('id');
        $submissionsMobile = collect($submissionsMobile)->groupBy('id');

        //echo '<pre>'; print_r($submissions); echo '</pre>';


        $tanks = \App\Tanks::orderBy('tankname', 'asc')->where(['enabled' => 1])->get();



        return view('submissions', ['submissionsDesktop' => $submissionsDesktop, 'submissionsMobile' => $submissionsMobile,'tanks'=>$tanks]);
    }

    public function showRejections(){
        //Get all records that aren't approved and haven't been decided by a manager yet.
        $rejectionsDesktop = DB::select("select * from rejected_submissions_seven_days where mobile='0' ORDER  BY proof_updated_at");
        $rejectionsMobile = DB::select("select * from rejected_submissions_seven_days where mobile='1' ORDER  BY proof_updated_at");

        $rejectionsDesktop=collect($rejectionsDesktop)->groupBy('id');
        $rejectionsMobile=collect($rejectionsMobile)->groupBy('id');

        return view('rejections', ['rejectionsDesktop' => $rejectionsDesktop, 'rejectionsMobile' => $rejectionsMobile]);
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
            'decided'=>'required|boolean',
            'answ' => 'required|boolean',
            'id' => 'required|integer',
            'score' => 'required|integer|between:0,999999999',
            'name' => 'required|max:25',
        ]);

        //complain to user if they sent crap
        if ($validator->fails()) {
            return response()->json(array('msg' => 'something went wrong', 'err' => $validator->messages()->toJson(), 'input' => $input), 202);
        }
        //don't believe the manager to actually send a valid id
        $proof = Proofs::find($request->input('id'));

        if ($proof == null) {
            //complain to user if they sent crap
            return response()->json(array('msg' => 'Record not found'), 202);
        }

        $record = Records::find($proof->id);


        $name=Names::find($record->nameId);


/*

        $oldrecord = Records::join('proofs', 'proofs.id', '=', 'records.id')->where([['proofs.approved', 1], ['records.score', $request->input('score')], ['records.tank_id', $record->tank_id], ['records.gamemode_id', $record->gamemode_id], ['records.id', '<>', $record->id]])->first();
        if ($oldrecord && $request->input('answ')) {
            return response()->json(array('msg' => 'There already is an record with the same score. I cannot approve this!', 'err' => $validator->messages()->toJson(), 'input' => $input), 202);
        }
*/
        //The proof has been decided and will be saved.
        DB::transaction(function () use ($proof, $request, $record,$name) {

            $record->score = $request->input('score');

            if ($name->name!=trim(strip_tags($request->input('name')))){
                $newName=Names::where('name',trim(strip_tags($request->input('name'))))->first();
                if ($newName==null){
                    $newName=new Names;
                    $newName->name=trim(strip_tags($request->input('name')));
                    $newName->save();
                }
                $record->nameId=$newName->id;
            }

            $record->save();
            $proof->approved = $request->input('answ');
            $proof->decided = $request->input('decided');
            $proof->approver_id = Auth::user()->id;
            $proof->save();
            if (!App::runningUnitTests()&& $proof->decided)
                $this->dispatch(new NotifyDiscordAboutSubmission($record,false, false,null));

        });


        $msg = 'Successfully changed record. It was approved: ' . ($proof->approved == '1' ? 'true' : 'false');
        return response()->json(array('msg' => $msg, 'input' => $input, 'score' => $record->score), 200);


    }


}
