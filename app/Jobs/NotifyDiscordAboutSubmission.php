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
    protected $newsubmitted;
    protected $client;

    protected $webhook_id;
    protected $webhook_token;

    private $numberOfMaxRecordsPerHourDiscordSpam = 6;


    /**
     * Create a new job instance.
     * @param Records $record
     * @param $newsubmitted
     *
     */
    public function __construct(Records $record, $newsubmitted)
    {
        $this->record = $record;
        $this->newsubmitted = $newsubmitted;

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
            'timeout' => 2.0,
        ]);

        $record = $this->record;

        $recordsnumber = Records::where([['created_at', '>=', Carbon::now()->subHour()],
            'ip_address' => $record->ip_address])->get()->count();


        if ($recordsnumber <= $this->numberOfMaxRecordsPerHourDiscordSpam && $this->webhook_id && $this->webhook_token) {
            $postcontent = null;

            $proof = $this->record->proof;

            $id = $record->id;
            $submittername = str_replace(array('|', '*', '^', '_', '#', '[', ']', '(', ')'), array('\|', '\*', '\^', '\_', '\#', '\[', '\]', '\(', '\)'), $record->name);
            $score = number_format($record->score);
            $tank = $record->tank->tankname;
            $gamemode = $record->gamemode->name;

            $link = $proof->submittedlink;

            $manager = $proof->user->name;
            $approved = $proof->approved;

            if ($this->newsubmitted) {

                $postcontent = ['content' =>
                    "**$submittername** submitted a new record *(id: $id)*!
                    Gamemode: $gamemode
                    Tank: $tank
                    Score: $score
                    $link"];
            } else {
                $action = $approved ? '__**approved**__' : '__**rejected**__';
                $postcontent = ['content' =>
                    "Submission *(id: $id)* ($gamemode, $tank with $score pts) from **$submittername** has been $action by $manager."];
            }

            $response = $this->client->request('POST', "webhooks/$this->webhook_id/$this->webhook_token", ['json' => $postcontent]);
        }
    }
}
