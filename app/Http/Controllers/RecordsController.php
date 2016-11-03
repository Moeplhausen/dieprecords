<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App;
use App\Tanks;
use App\Gamemodes;
use App\Proofs;
use App\Records;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

use App\Http\Requests;
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
                $data=$this->getBestTanksAndUsersData();
                return view('statistics', ['besttanks' => $data->sumBestTanks,'bestSubmitters'=>$data->bestSubmitters])->render();
            });
        }
        $data=$this->getBestTanksAndUsersData();

        return view('statistics', ['besttanks' => $data->sumBestTanks,'bestSubmitters'=>$data->bestSubmitters]);
    }


    private function getBestTanksAndUsersData()
    {

        /*
        * Get Best Tanks when you sum the gamemodes up
        */
        $sumBestTanks = DB::select("SELECT best.tankname,sum(best.score) AS totalScore FROM (SELECT DISTINCT besttanksview.record_id AS record_id,besttanksview.tankname AS tankname,besttanksview.tank_id AS tank_id,besttanksview.score AS score FROM besttanksview) best GROUP BY tankname  ORDER BY totalScore DESC ");
        for ($i = 0; $i < count($sumBestTanks); $i++) {
            $record = $sumBestTanks[$i];
            $record->row = $i + 1;
            $record->scorefull = $record->totalScore;
            $record->score = $this->thousandsCurrencyFormat($record->totalScore);
        }

        $bestSubmitters = DB::select("
SELECT recordholders.name AS name,COUNT(recordholders.name) AS numberOfRecords,MAX(recordholders.score) AS maxScore 
FROM (SELECT DISTINCT record_id,name,score FROM besttanksview) recordholders
GROUP BY recordholders.name
ORDER BY numberOfRecords  DESC, name ASC");

        for ($i = 0; $i < count($bestSubmitters); $i++) {
            $submitter = $bestSubmitters[$i];
            $submitter->row = $i + 1;
            $submitter->scorefull = $submitter->maxScore;
            $submitter->score = $this->thousandsCurrencyFormat($submitter->maxScore);
        }



        return (object)array('sumBestTanks' => $sumBestTanks, 'bestSubmitters' => $bestSubmitters);
    }


    /**
     * This function returns the default records view.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRecords()
    {

        $recordsdata = $this->getRecordsData();

        return view('records', ["tanknames" => $recordsdata->tanks, "allrecords" => $recordsdata->records, 'gamemodes' => $recordsdata->gamemodes]);
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
        $tanks = \App\Tanks::orderBy('tankname', 'asc')->get();


        /*General idea: Get all scores and join them with proofs to get only approved ones.
        Then get the max score by grouping tank_id and gamemode_id.
        Afterwards we join the result with scores again to get the other collumns of the record (like the id of the record).
        Now we only join them with the other tables to get infos like the actual name of the tank, gamemode and proof-link
        Be aware that for a records with multiple proof-links we get a result each
        */
        $records = DB::select("SELECT * FROM besttanksview");

//Now get the best tanks by gamemode
        $gamemodewinners = DB::select("
SELECT DISTINCT 
                sortedrecords.id AS record_id,
                sortedrecords.score AS score, 
                gamemodes.name    AS gamemode
FROM   (SELECT record.* 
        FROM   (SELECT records.* FROM records INNER JOIN proofs ON records.id=proofs.id WHERE proofs.approved='1') record 
               INNER JOIN (SELECT DISTINCT gamemode_id, 
                                  Max(score) AS score 
                           FROM   records 
                                  INNER JOIN proofs 
                                          ON records.id = proofs.id 
                           WHERE  proofs.approved = '1' 
                           GROUP  BY
                                     gamemode_id) grouprecord 
                       ON record.gamemode_id = grouprecord.gamemode_id 
                          AND record.score = grouprecord.score) AS sortedrecords 
       INNER JOIN gamemodes 
               ON sortedrecords.gamemode_id = gamemodes.id 
ORDER  BY score DESC
          ");


        $gamemodewinnersCssClass = array();

        for ($i = 0; $i < count($gamemodewinners); $i++) {

            $gamemodewinnersCssClass[$gamemodewinners[$i]->record_id] = 'gamemodewinner' . ' gamemodewinner' . $gamemodewinners[$i]->gamemode;

            if ($i == 0) {
                $gamemodewinnersCssClass[$gamemodewinners[$i]->record_id] .= ' totalwinnerscore';
            }
        }


        /*        echo '<pre>';
                print_r($gamemodewinners);
                echo '</pre>';*/

        /*   echo '<pre>';
           print_r($records);
           echo '</pre>';*/

        /*
         * To easily display them on a page, we want to format the score and make sure that we only have x submissions for x gamemodes in a row
         */
        for ($i = 0; $i < count($records); $i++) {
            $record = $records[$i];


            $record->scorefull = $record->score;
            $record->score = $this->thousandsCurrencyFormat($record->score);
            $links = array($record->link);
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

        //get all gamemodes for the form
        $gamemodes = \App\Gamemodes::orderBy('id', 'asc')->get();


        return (object)array('tanks' => $tanks, 'gamemodes' => $gamemodes, 'records' => $records);


    }


    public
    function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'inputname' => 'required|max:25',
            'gamemode_id' => 'required|integer|max:256',
            'selectclass' => 'required|integer|max:256',
            'score' => 'required|integer|between:0,999999999',
            'proof' => [
                'required',
                'url',
                'regex:~^http(?:s?):\/\/(?:www\.)?youtu(?:be\.com\/watch\?v=|\.be\/)([\w\-\_]*)(&(amp;)?‌​[\w\?‌​=]*)?|(?:https?:\/\/)(?:www\.)?(?:(?:cdn\.discordapp\.com|images\-\d+\.discordapp\.net|i\.redd\.it|i\.imgur\.com|zippy\.gfycat.com|fat\.gfycat\.com|s\d+\.postimg\.org)(.*\.png|.*\.jpg|.*\.PNG|.*\.JPG|.*\.webm|.*\.WEBM)|imgur\.com|m\.imgur\.com).*~x'
            ]//In theory also the youtube ending will also be accepted for the other sites. Shouldn't be a problem though.
        ]);
        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }
        $request->proof = str_replace("http://", "https://", $request->proof);


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

        //Deny if current record is higher or equal if exists
        if ($currentbestone && $currentbestone >= $request->score)
            return redirect('/')->with('status', [(object)['status' => 'alert-warning', 'message' => "Sorry but the current record for $tankinfo->tankname on $gamemodeinfo->name is $currentbestone"]]);


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
                //echo 'Exception abgefangen: ',  $e->getMessage(), "\n";
                return redirect('/')->withInput()->withErrors(array('message' => 'Could not parse imgur links! Try a direct image link'));
            } finally {

            }
        } else {
            $request->proof = array($request->proof);
        }


        //Everything seems fine, let us add them
        DB::transaction(function () use ($request) {


            $record = new Records();
            $record->name = trim(strip_tags($request->inputname));
            $record->score = $request->score;
            $record->tank_id = $request->selectclass;
            $record->gamemode_id = $request->gamemode_id;
            $record->ip_address = $request->ip();
            $record->save();

            $proof = new Proofs();
            $proof->approved = false;
            $proof->save();

            for ($i = 0; $i < count($request->proof); $i++) {
                $prooflink = new App\Proofslink();
                $prooflink->proof_id = $proof->id;
                $prooflink->proof_link = $request->proof[$i];
                $prooflink->save();
            }
        });

        return redirect('/')->with('status', [(object)['status' => 'alert-success', 'message' => 'Your submission will be handled shortly.', $currentbestone]]);
    }


// http://stackoverflow.com/questions/4371059/shorten-long-numbers-to-k-m-b
    private
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

        $imageApi = $this->imgur->getApi("AlbumOrImage");

        $return = array();
        $imglinkarray = $imageApi->find($id);

        if (0 === strpos($imglinkarray['link'], 'http://i.')) {//directimage
            array_push($return, str_replace("http://", "https://", $imglinkarray['link']));
        } else {
            for ($i = 0; $i < count($imglinkarray['images']); $i++) {
                array_push($return, str_replace("http://", "https://", $imglinkarray['images'][$i]['link']));
            }
        }
        return $return;
    }
}
