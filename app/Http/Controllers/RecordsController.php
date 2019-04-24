<?php

namespace App\Http\Controllers;

use App;
use App\Gamemodes;
use App\Http\Requests;
use App\Proofs;
use App\Names;
use App\Records;
use App\Tanks;
use App\DiscordNames;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Kurt\Imgur\Imgur;

class RecordsController extends Controller
{

    /**
     * Imgur instance.
     *
     * @var \Kurt\Imgur\Imgur
     */
    private $imgur;

    public function __construct(Imgur $imgur)
    {
        $this->imgur = $imgur;
    }


    public function showBestTanks()
    {
        if (Auth::guest() && !App::isLocal() && !App::runningUnitTests()) {
            return Cache::remember('statistics', 10, function () {
                $data = $this->getBestTanksAndUsersData();
                return view('statistics', ['bestTanksDestkop' => $data->sumBestTanksDesktop, 'bestSubmittersDesktop' => $data->bestSubmittersDesktop])->render();
            });
        }
        $data = $this->getBestTanksAndUsersData();

        return view('statistics', ['bestTanksDestkop' => $data->sumBestTanksDesktop, 'bestSubmittersDesktop' => $data->bestSubmittersDesktop]);

    }


    private function getBestTanksAndUsersData()
    {

        /*
        * Get Best Tanks when you sum the gamemodes up
        */
        $sumBestTanksDesktop = DB::select("SELECT best.tankname,sum(best.score) AS totalScore FROM (SELECT DISTINCT besttanksview.record_id AS record_id,besttanksview.tankname AS tankname,besttanksview.tank_id AS tank_id,besttanksview.score AS score FROM besttanksview WHERE besttanksview.world_record=1 AND besttanksview.mobile='0') best GROUP BY tankname   ORDER BY totalScore DESC ");
        for ($i = 0; $i < count($sumBestTanksDesktop); $i++) {
            $record = $sumBestTanksDesktop[$i];
            $record->row = $i + 1;
            $record->scorefull = $record->totalScore;
            $record->score = $this->thousandsCurrencyFormat($record->totalScore);
        }

        $bestSubmittersDesktop = DB::select("
SELECT recordholders.name AS name,COUNT(recordholders.name) AS numberOfRecords,MAX(recordholders.score) AS maxScore 
FROM (SELECT DISTINCT record_id,name,score FROM besttanksview WHERE besttanksview.world_record=1 AND besttanksview.mobile='0') recordholders
GROUP BY recordholders.name
ORDER BY numberOfRecords  DESC, name ASC");

        for ($i = 0; $i < count($bestSubmittersDesktop); $i++) {
            $submitter = $bestSubmittersDesktop[$i];
            $submitter->row = $i + 1;
            $submitter->scorefull = $submitter->maxScore;
            $submitter->score = $this->thousandsCurrencyFormat($submitter->maxScore);
        }


        return (object)array('sumBestTanksDesktop' => $sumBestTanksDesktop, 'bestSubmittersDesktop' => $bestSubmittersDesktop);
    }


    private function filterRecords($allrecords, $filterids,$inverted=false)
    {
        $records = $allrecords->filter(function ($obj, $key) use ($filterids,$inverted) {
            $id = $obj->id;
            return $filterids->contains($id) xor $inverted;
        });
        return $records;
    }

    public function getRecordsByName($name)
    {
        $currentWorldRecordsIds = DB::table('besttanksview')->select('record_id')->distinct()->where('name', $name)->where('world_record',1)->get()->pluck('record_id');


        $formerWorldRecordsid = collect(DB::select("SELECT DISTINCT approvedrecords.id FROM approvedrecords INNER JOIN names on names.id=approvedrecords.nameId WHERE names.name=? AND approvedrecords.world_record=1 AND approvedrecords.id NOT IN (SELECT record_id FROM besttanksview WHERE world_record=1 AND name=?)", [$name, $name]));

        /*
        echo '<pre>';
        print_r($currentWorldRecordsIds);

        print_r($formerWorldRecordsid);
        echo '</pre>';
        */

        $allrecords = DB::table('records')->select('records.id as id',
            'names.name as name',
            'gamemodes.id as gamemode_id',
            'gamemodes.name as gamemode',
            'gamemodes.mobile as mobile',
            'tanks.id as tank_id',
            'tanks.tankname as tank',
            'proofs.submittedlink as submittedlink',
            'score as scorefull')
            ->join('proofs', 'proofs.id', '=', 'records.id')
            ->join('gamemodes', 'gamemodes.id', '=', 'records.gamemode_id')
            ->join('tanks', 'tanks.id', '=', 'records.tank_id')
            ->join('names','names.id','=','records.nameId')
            ->where('names.name', 'like', $name)
            ->where('proofs.approved','=',1)
            ->orderBy('tank')->get();


        foreach ($allrecords as $record) {
            $record->score = RecordsController::thousandsCurrencyFormat($record->scorefull);
        }


        $formerWorldRecordsid = $formerWorldRecordsid->pluck('id');

        $worldRecords=$this->filterRecords($allrecords,$currentWorldRecordsIds->merge($formerWorldRecordsid));


        $currentWorldRecords = $this->filterRecords($worldRecords, $currentWorldRecordsIds);
        $formerWorldRecord = $this->filterRecords($worldRecords, $formerWorldRecordsid);

        $justHighScores=$this->filterRecords($allrecords,$currentWorldRecordsIds->merge($formerWorldRecordsid),true);


        /*     echo '<pre>';
             print_r($currentWorldRecords);
             echo '</pre>';*/

        return ['current' => $currentWorldRecords, 'former' => $formerWorldRecord,'scores'=>$justHighScores];

    }

    public function getTankHistory($tankid, $gamemodeid, $desktop)
    {

        $gamemodeMobileSQLClase = ' WHERE gamemodes.mobile=' . ($desktop ? '0' : 1) . ' ';
        $tankhistory = DB::select("
SELECT record.id, namey as name,record.score,tanks.tankname AS tank,record.created_at,record.updated_at, gamemodes.name AS gamemode,record.submittedlink AS proof
        FROM   (SELECT records.*,proofs.submittedlink,names.name as namey FROM records INNER JOIN proofs ON records.id=proofs.id INNER JOIN names on names.id=records.nameId WHERE proofs.approved='1' and records.tank_id=$tankid and records.gamemode_id=$gamemodeid AND records.world_record=1) AS record 
       INNER JOIN gamemodes 
               ON record.gamemode_id = gamemodes.id 
       INNER JOIN tanks
               ON record.tank_id = tanks.id $gamemodeMobileSQLClase
               
ORDER  BY score ASC
          ");
        foreach ($tankhistory as $record) {
            $record->scorefull = RecordsController::thousandsCurrencyFormat($record->score);
        }


        return ['input' => ['tankid' => $tankid, 'gamemodeid' => $gamemodeid, 'desktop' => $desktop], 'data' => $tankhistory, 'test' => count($tankhistory)];
    }



    public function getUserName(Request $request,$discord_user){
        $discordUserLink=DiscordNames::where('discordId','=',$discord_user)->first();
        if ($discordUserLink==null)
            return \GuzzleHttp\json_encode(array('status' => 'error', 'content' => "Sorry, no name was found."));

        return \GuzzleHttp\json_encode(array('status' => 'success', 'content' => $discordUserLink->name->name));

    }


    public function editDiscordName(Request $request,$discord_user,$newName,$forceUpdate=false){



        $reqNewName=trim(strip_tags($newName));

        if ($reqNewName==''||strlen($reqNewName)>25)
            return \GuzzleHttp\json_encode(array('status' => 'error', 'content' => "Sorry, but that name is not allowed."));

        $name=Names::where('name','=',$reqNewName)->get();
        if (!$name->isEmpty())
            return \GuzzleHttp\json_encode(array('status' => 'error', 'content' => "Sorry, that name is already in use."));

        $discordUserLink=DiscordNames::where('discordId','=',$discord_user)->first();

        if ($discordUserLink==null)
        return \GuzzleHttp\json_encode(array('status' => 'error', 'content' => "Sorry, but you have no registered name."));


        if ($discordUserLink->mayUpdate||$forceUpdate) {
            $discordUserLink->name->name = $reqNewName;
            $discordUserLink->name->save();
        }else{
            return \GuzzleHttp\json_encode(array('status' => 'error', 'content' => "Sorry, you are not allowed to change your name."));
        }

        return \GuzzleHttp\json_encode(array('status' => 'success', 'content' => "Your name has been changed to: ".$reqNewName));


    }
    public function setEditRightDiscordName(Request $request,$discord_user,$mayEdit,$newName=''){

        $discordUserLink=DiscordNames::where('discordId','=',$discord_user)->first();
        if ($discordUserLink==null)
            return \GuzzleHttp\json_encode(array('status' => 'error', 'content' => "Discord user has no registered name"));
        $discordUserLink->mayUpdate=$mayEdit;
        $discordUserLink->save();
        if ($newName!='')
            return $this->editDiscordName($request,$discord_user,$newName,true);
        return \GuzzleHttp\json_encode(array('status' => 'success', 'content' => "User updated."));


    }
    public function setDiscordNameConnection(Request $request,$discord_user,$request_name){
        $reqName=trim(strip_tags($request_name));

        $name=Names::where('name','=',$reqName)->get();
        if ($name->isEmpty())
            return \GuzzleHttp\json_encode(array('status' => 'error', 'content' => "No record with that name found."));

        $name=$name[0];

        $discordUserLinkUsername=DiscordNames::where('nameId','=',$name->id)->get();
        $discordUserLinkDiscord=DiscordNames::where('discordId','=',$discord_user)->get();


        if (!$discordUserLinkUsername->isEmpty()){
            $discordUserLinkUsername=$discordUserLinkUsername[0];
            $discordUserLinkUsername->discordId = $discord_user;
            $discordUserLinkUsername->save();
        }elseif (!$discordUserLinkDiscord->isEmpty()){
            $discordUserLinkDiscord=$discordUserLinkDiscord[0];
            $discordUserLinkDiscord->nameId = $name->id;
            $discordUserLinkDiscord->save();
        }
        else {
           $con=new DiscordNames;
           $con->discordId=$discord_user;
           $con->nameId=$name->id;
           $con->save();
        }
        return \GuzzleHttp\json_encode(array('status' => 'success', 'content' => "User registered."));


    }


    public function showRecordsByName($name)
    {

/*                echo '<pre>';
        print_r($this->getRecordsByName($name));
        echo '</pre>';*/

        return view('recordsbyname', ['name' => $name, 'userworldrecords' => array(), 'formeruserworldrecords' => array()]);
    }

    /**
     * This function returns the default records view.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRecords()
    {

        $recordsdata = $this->getRecordsData();


        return view('records', ["tanknames" => $recordsdata->tanks, "allrecordsDesktop" => $recordsdata->recordsDesktop, "allrecordsMobile" => $recordsdata->recordsMobile, 'gamemodesDesktop' => $recordsdata->gamemodesDesktop, 'gamemodesMobile' => $recordsdata->gamemodesMobile]);
    }


    public function showTOP100Records()
    {


        if (Auth::guest() && !App::isLocal() && !App::runningUnitTests()) {
            return Cache::remember('top100', 10, function () {
                //we need all tank names and ids to show them in the form where to submit a new score
                $tanks = \App\Tanks::orderBy('tankname', 'asc')->where(['enabled' => 1])->get();
                $gamemodesDesktop = \App\Gamemodes::orderBy('id', 'asc')->where(['mobile' => 0])->get();
                $gamemodesMobile = \App\Gamemodes::orderBy('id', 'asc')->where(['mobile' => 1])->get();
                $data = $this->getTOP100Records();
                return view('top100', ['tanknames' => $tanks, 'gamemodesDesktop' => $gamemodesDesktop, 'gamemodesMobile' => $gamemodesMobile, 'topRecords' => $data->data])->render();
            });
        }
        $data = $this->getTOP100Records();
        //we need all tank names and ids to show them in the form where to submit a new score
        $tanks = \App\Tanks::orderBy('tankname', 'asc')->where(['enabled' => 1])->get();
        $gamemodesDesktop = \App\Gamemodes::orderBy('id', 'asc')->where(['mobile' => 0])->get();
        $gamemodesMobile = \App\Gamemodes::orderBy('id', 'asc')->where(['mobile' => 1])->get();

        return view('top100', ['tanknames' => $tanks, 'gamemodesDesktop' => $gamemodesDesktop, 'gamemodesMobile' => $gamemodesMobile, 'topRecords' => $data->data]);

    }


    private function getTOP100Records()
    {


        /*
* Get Best Tanks when you sum the gamemodes up
*/
        $topRecords = DB::select("SELECT approvedrecords.id, approvedrecords.world_record, names.name,users.name as approvername,approvedrecords.score,gamemodes.name as gamemode,tanks.tankname as tank,proofs.submittedlink,proofs.created_at FROM approvedrecords inner join proofs on approvedrecords.id=proofs.id INNER JOIN tanks on approvedrecords.tank_id=tanks.id INNER JOIN gamemodes ON approvedrecords.gamemode_id=gamemodes.id INNER JOIN users ON proofs.approver_id=users.id INNER JOIN names on names.id=approvedrecords.nameId WHERE gamemodes.mobile=0 ORDER BY `approvedrecords`.`score`  DESC LIMIT 100");
        for ($i = 0; $i < count($topRecords); $i++) {
            $record = $topRecords[$i];
            $record->row = $i + 1;
            $record->scorefull = $record->score;
            $record->score = $this->thousandsCurrencyFormat($record->score);
        }


        return (object)array('data' => $topRecords);

    }


    private function getRecordsData()
    {


        if (Auth::guest() && !App::isLocal() && !App::runningUnitTests()) {
            return Cache::remember('records', 10, function () {
                return $this->recordsFetcher();
            });
        } else { //Managers need up to date records
            return $this->recordsFetcher();
        }

    }


    /**
     * This function returns the tank with the highest score by tank class and gamemode
     * @return Records
     */
    private function recordsFetcher()
    {


        //we need all tank names and ids to show them in the form where to submit a new score
        $tanks = \App\Tanks::orderBy('tankname', 'asc')->where(['enabled' => 1])->get();


        /*        echo '<pre>';
                print_r($gamemodewinners);
                echo '</pre>';*/

        /*   echo '<pre>';
           print_r($records);
           echo '</pre>';*/


        //get all gamemodes for the form
        $gamemodesDesktop = \App\Gamemodes::orderBy('id', 'asc')->where(['mobile' => 0])->get();
        $gamemodesMobile = \App\Gamemodes::orderBy('id', 'asc')->where(['mobile' => 1])->get();


        return (object)array('tanks' => $tanks, 'gamemodesDesktop' => $gamemodesDesktop, 'gamemodesMobile' => $gamemodesMobile, 'recordsDesktop' => $this->getBestRecords(true), 'recordsMobile' => $this->getBestRecords(false));


    }


    public static function getBestRecords($desktop = true)
    {


        $gamemodeMobileSQLClase = ' WHERE gamemodes.mobile=' . ($desktop ? '0' : 1) . ' ';


//Now get the best tanks by gamemode
        $gamemodewinners = DB::select("
SELECT DISTINCT 
                sortedrecords.id AS record_id,
                sortedrecords.score AS score, 
                gamemodes.name    AS gamemode
FROM   (SELECT record.* 
        FROM   (SELECT records.* FROM records INNER JOIN proofs ON records.id=proofs.id WHERE proofs.approved=1 AND proofs.decided=1 AND records.world_record=1) record 
               INNER JOIN (SELECT DISTINCT gamemode_id, 
                                  Max(score) AS score 
                           FROM   records 
                                  INNER JOIN proofs 
                                          ON records.id = proofs.id 
                           WHERE  proofs.approved = '1' AND records.world_record=1 AND proofs.decided=1
                           GROUP  BY
                                     gamemode_id) grouprecord 
                       ON record.gamemode_id = grouprecord.gamemode_id 
                          AND record.score = grouprecord.score) AS sortedrecords 
       INNER JOIN gamemodes 
               ON sortedrecords.gamemode_id = gamemodes.id $gamemodeMobileSQLClase
ORDER  BY score DESC
          ");


        $gamemodewinnersCssClass = array();

        for ($i = 0; $i < count($gamemodewinners); $i++) {

            $gamemodewinnersCssClass[$gamemodewinners[$i]->record_id] = 'gamemodewinner' . ' gamemodewinner' . $gamemodewinners[$i]->gamemode;

            if ($i == 0) {
                $gamemodewinnersCssClass[$gamemodewinners[$i]->record_id] .= ' totalwinnerscore';
            }
        }


        /*General idea: Get all scores and join them with proofs to get only approved ones.
Then get the max score by grouping tank_id and gamemode_id.
Afterwards we join the result with scores again to get the other collumns of the record (like the id of the record).
Now we only join them with the other tables to get infos like the actual name of the tank, gamemode and proof-link
Be aware that for a records with multiple proof-links we get a result each
*/
        $records = DB::select('SELECT * FROM besttanksview WHERE mobile=' . ($desktop ? '0' : 1) . ' AND tank_enabled=1 AND world_record=1 ORDER BY tankname,gamemode_id, prooflink_id');
        /*
 * To easily display them on a page, we want to format the score and make sure that we only have x submissions for x gamemodes in a row
 */


        for ($i = 0; $i < count($records); $i++) {
            $record = $records[$i];


            $record->scorefull = $record->score;
            $record->score = RecordsController::thousandsCurrencyFormat($record->score);
            $links = array($record->link);
            // Records with the same id but different prooflink should be next to each.
            // We simply look ahead if there are other records with the same id behind this one and add the links on them.
            while ($i + 1 < count($records) && $record->record_id == $records[$i + 1]->record_id) {
                array_push($links, $records[$i + 1]->link);
                array_splice($records, $i + 1, 1);
            }

            unset($record->link);

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


/*        echo '<pre>';
        print_r($records);
        echo '</pre>';*/


        return $records;
    }


    public function submit(Request $request, $shouldWriteToDatabase = true, $worldRecordSubmission = true)
    {

        return redirect('/')->withInput()->withErrors(array('message' => 'submissions has been disabled:('));


        $validator = Validator::make($request->all(), [
            'inputname' => 'required|max:25',
            'gamemode_id' => 'required|integer|max:256',
            'selectclass' => 'required|integer|max:256',
            'score' => 'required|integer|between:40000,999999999',

        ]);
        if ($validator->fails()) {
                return redirect('/')
                    ->withInput()
                    ->withErrors($validator);
        }
        $request->proof = str_replace("http://", "https://", $request->proof);


        //Check if proof is video or not
        $video = false;
        if (preg_match("~^http(?:s?):\/\/(?:www\.)?youtu(?:be\.com\/watch\?v=|\.be\/)([\w\-\_]*)(&(amp;)?‌​[\w\?‌​=]*)?~x", $request->proof)) {
            $video = true;
        }


        //make sure the tank actually exists and not just believe the user
        $tank = Tanks::where('id', '=', $request->selectclass)->get();
        //same with gamemode
        $gamemode = Gamemodes::where('id', '=', $request->gamemode_id)->get();

        if ($gamemode->isEmpty() || $tank->isEmpty())
                return redirect('/');

        $tankinfo = $tank[0];
        $gamemodeinfo = $gamemode[0];


        //The case that there are two undecided submissions with the same score,gamemode,tank must be prevented (should never happen anyway)
        //get current record for this tank and gamemode
        $matchThese = [
            'proofs.decided' => '0',
            'records.tank_id' => $tankinfo->id,
            'records.gamemode_id' => $gamemodeinfo->id,
            'records.score' => $request->score];
        $samescore = DB::table('records')->join('proofs', 'records.id', '=', 'proofs.id')->join('names','names.id','=','records.nameId')->select('*')->where($matchThese)->get();
        if (!$samescore->isEmpty()) {
            $name = $samescore[0]->name;
                return redirect('/')->with('status', [(object)['status' => 'alert-warning', 'message' => "Sorry but there already is an undecided submission from $name for the same score "]]);
        }


        //get current record for this tank and gamemode
        $matchThese = [
            'proofs.approved' => '1',
            'records.tank_id' => $tankinfo->id,
            'records.gamemode_id' => $gamemodeinfo->id];
        $currentbestone = DB::table('records')->join('proofs', 'records.id', '=', 'proofs.id')->select('*')->where($matchThese)->max('score');
        $currentbestone = DB::table('records')->join('proofs', 'records.id', '=', 'proofs.id')->join('names','names.id','=','records.nameId')->select('*')->where('score', $currentbestone)->get();

        if ($currentbestone && count($currentbestone) > 0)
            $currentbestone = $currentbestone[0];
        else
            $currentbestone = null;

        //Deny if current record is higher or equal if exists
        if ($worldRecordSubmission && $currentbestone && $currentbestone->score >= $request->score) {
            $worldRecordSubmission = false;

            //$top100Record = DB::select("SELECT approvedrecords.id, approvedrecords.name,users.name as approvername,approvedrecords.score,gamemodes.name as gamemode,tanks.tankname as tank,proofs.submittedlink,proofs.created_at FROM approvedrecords inner join proofs on approvedrecords.id=proofs.id INNER JOIN tanks on approvedrecords.tank_id=tanks.id INNER JOIN gamemodes ON approvedrecords.gamemode_id=gamemodes.id INNER JOIN users ON proofs.approver_id=users.id WHERE gamemodes.mobile=0 ORDER BY `approvedrecords`.`score`  DESC LIMIT 99,1");

            if ($gamemodeinfo->mobile == true or ($request->score < 1000000))
                    return redirect('/')->with('status', [(object)['status' => 'alert-warning', 'message' => "Sorry but the current record for $tankinfo->tankname on $gamemodeinfo->name is $currentbestone->score and your record score not at least 1.000.000 points!"]]);

        }


        //Deny if there are too many open submission for this ip
        $matchThese = [
            'proofs.decided' => '0',
            'records.ip_address' => $request->ip()];
        $currentopensubsbyip = DB::table('records')->join('proofs', 'records.id', '=', 'proofs.id')->select('*')->where($matchThese)->count();
        if ($currentopensubsbyip > 15) {
            return redirect('/')->withInput()->withErrors(array('message' => 'Too many open submissions from you :('));
        }


        //save original submitted proof url

        $orgProof = $request->proof;


        //Test if we have an imgur link that is not linking directly to an image
        if (preg_match("~^(?:https?:\/\/)(?:www\.)?(?:imgur\.com|m\.imgur\.com)(?:.*)~x", $request->proof)) {
            try {
                //get imgur id
                $output = "";
                if (preg_match("/\/\K\w+(?=[^\/]*$)/", $request->proof, $output)) {
                    for ($i = 0; $i < count($output); $i++) {
                        $request->proof = $this->getImgurDirectLinks($output[$i]);
                        if (count($request->proof) == 0)
                                return redirect('/')->withInput()->withErrors(array('message' => 'Could not parse imgur links!'));
                    }
                }
            } catch (Exception $e) {
                    return redirect('/')->withInput()->withErrors(array('message' => 'Could not parse imgur links! Try a direct image link'));
            } finally {

            }
        } else {
            $request->proof = array($request->proof);
        }


        //Everything seems fine, let us add them
        if ($shouldWriteToDatabase) {
            DB::transaction(function () use ($request, $orgProof, $currentbestone, $video, $worldRecordSubmission) {

                $newName=Names::where('name',trim(strip_tags($request->inputname)))->first();

                    if ($newName==null){
                        $newName=new Names;
                        $newName->name=trim(strip_tags($request->inputname));
                        $newName->save();
                    }



                $record = new Records();
                $record->nameId = $newName->id;
                $record->score = $request->score;
                $record->tank_id = $request->selectclass;
                $record->gamemode_id = $request->gamemode_id;
                $record->ip_address = $request->ip();
                $record->world_record = $worldRecordSubmission ? 1 : 0;
                $record->save();

                $proof = new Proofs();
                $proof->id = $record->id;
                $proof->submittedlink = $orgProof;
                $proof->approved = false;
                $proof->save();

                for ($i = 0; $i < count($request->proof); $i++) {
                    $prooflink = new App\Proofslink();
                    $prooflink->proof_id = $proof->id;
                    $prooflink->proof_link = $request->proof[$i];
                    $prooflink->save();
                }

                if (!App::runningUnitTests())
                    $this->dispatch(new App\Jobs\NotifyDiscordAboutSubmission($record, $video, true, $currentbestone));

            });
        }

            return redirect('/')->with('status', [(object)['status' => 'alert-success', 'message' => 'Your submission will be handled shortly.']]);

    }


// http://stackoverflow.com/questions/4371059/shorten-long-numbers-to-k-m-b
    private static
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

    private
    function getImgurDirectLinks($id)
    {

        $imageApi = $this->imgur->getApi("albumOrImage");

        $return = array();
        $imglinkarray = $imageApi->find($id);

        $isAlbum = false;


        try {
            $test = $this->imgur->getApi("album")->album($id);
            $imglinkarray = $test;
            $isAlbum = true;
        } catch (\Exception $e) {

        }


        if (!$isAlbum) {//directimage
            array_push($return, str_replace("http://", "https://", $imglinkarray['link']));
        } else {
            for ($i = 0; $i < count($imglinkarray['images']); $i++) {
                array_push($return, str_replace("http://", "https://", $imglinkarray['images'][$i]['link']));
            }
        }
        return $return;
    }


}
