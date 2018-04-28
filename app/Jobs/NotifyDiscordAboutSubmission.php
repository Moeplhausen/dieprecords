<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Records;

use GuzzleHttp\Client;

class NotifyDiscordAboutSubmission implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;


    protected $record;
    protected $video;
    protected $newsubmitted;
    protected $currentbestone;
    protected $client;

    protected $webhook_id;
    protected $webhook_token;

    private $numberOfMaxRecordsPerHourDiscordSpam = 10;


    /**
     * Create a new job instance.
     * @param Records $record
     * @param $newsubmitted
     *
     */
    public function __construct(Records $record,$video, $newsubmitted,$currentbestone)
    {
        $this->record = $record;
        $this->video = $video;
        $this->newsubmitted = $newsubmitted;
        $this->currentbestone=$currentbestone;

        $this->webhook_id = env('DISCORD_WEBHOOK_ID', null);
        $this->webhook_token = env('DISCORD_WEBHOOK_TOKEN', null);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://discordapp.com/api/',
            // You can set any number of default request options.
            'timeout' => 10.0,
        ]);

        $record = $this->record;

        $recordsnumber = Records::where([['created_at', '>=', Carbon::now()->subHour()],
            'ip_address' => $record->ip_address])->get()->count();


        if ($recordsnumber <= $this->numberOfMaxRecordsPerHourDiscordSpam && $this->webhook_id && $this->webhook_token && $record->world_record==1) {
            $postcontent = null;

            $proof = $this->record->proof;


            $id = $record->id;
            $submittername = str_replace(array('|', '*', '^', '_', '#', '[', ']', '(', ')'), array('\|', '\*', '\^', '\_', '\#', '\[', '\]', '\(', '\)'), $record->name);
            $score = number_format($record->score);
            $tank = $record->tank->tankname;
            $gamemode = $record->gamemode->name;

            $link = $proof->submittedlink;
            $proof_link=$proof->links[0]->proof_link;

            $manager = $proof->user->name;
            $approved = $proof->approved;

            $mobile=$record->gamemode->mobile?'Yes':'No';

            $embeds=[];

            if ($this->newsubmitted) {


                $fields=[['name'=>'Tank','value'=>$tank,'inline'=>true],
                    ['name'=>'Gamemode','value'=>$gamemode,'inline'=>true],
                    ['name'=>'Mobile','value'=>$mobile,'inline'=>true],
                    ['name'=>'Score','value'=>$score,'inline'=>true],
                ];


                if ($this->currentbestone)
                {
                    array_push($fields,['name'=>'Current Holder','value'=>$this->currentbestone->name,'inline'=>true]);
                    array_push($fields,['name'=>'Current Score','value'=>number_format($this->currentbestone->score),'inline'=>true]);
                }

                if ($this->video)
                    array_push($fields,['name'=>'Proof','value'=>$proof_link,'inline'=>false]);


                $embedinfo1=['title'=>'Submission by __'.$submittername.'__ (id: '.$id.')',
                    'fields'=>$fields,
                    'color'=>16776960,
                    'image'=>['url'=>$proof_link],
                ];







                array_push($embeds,$embedinfo1);


                if (count($proof->links)>1){
                    array_push($embeds,[
                        'color'=>16776960,
                        'image'=>['url'=>$proof->links[count($proof->links)-1]->proof_link,
                    ]]);
                }


                $postcontent=['embeds'=>$embeds,];


            } else {
                $action = $approved ? '__**approved**__' : '__**rejected**__';

                $fields=[['name'=>'Submission id','value'=>$id,'inline'=>true],
                    ['name'=>'Action','value'=>$action,'inline'=>true],
                    ['name'=>'Gamemode','value'=>$gamemode,'inline'=>true],
                    ['name'=>'Tank','value'=>$tank,'inline'=>true],
                    ['name'=>'Score','value'=>$score,'inline'=>true],
                    ['name'=>'Manager','value'=>$manager,'inline'=>true],
                ];

                $embedinfo1=['title'=>'Submission by __'.$submittername.'__',
                    'fields'=>$fields,
                    'color' =>$approved?65280:16711680
                ];
                array_push($embeds,$embedinfo1);
                $postcontent=['embeds'=>$embeds];


            }

            $response = $this->client->request('POST', "webhooks/$this->webhook_id/$this->webhook_token", ['json' => $postcontent]);



        }
    }
}
