<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

use App\Sip_ref_activity;
use App\Sip_trx_form_submission;
use App\User;
use App\Sip_trx_site_config;
use App\Sip_trx_user_notification;

class SendBulkData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:bulk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending bulk submissions data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $url = '';
        $site_config = Sip_trx_site_config::first();
        $submissions = Sip_trx_form_submission::where('created_at',Carbon::now())
                                                ->get();

        $tmp_array = [];
        $tmp_users = [];

        foreach($submissions as $submission){

            $user = $submission->user;
            $config = $user->config;

            if(is_object($config) 
                && $config->sip_trx_user_configs_trf_type == 'online' 
                && $config->sip_trx_user_configs_trf_data_type == 'bulk'){
                
                $tmp_value = [
                        
                        'submission_id' => $submission->sip_trx_form_submission_id, 
                        'submission_form_id' => $submission->sip_trx_form_submission_form_id, 
                        'submission_user_id' => $submission->sip_trx_form_submission_user_id

                        ];

                foreach($submission->values as $value){
                    
                    $arr = array( $value->sip_trx_form_values_code => $value->sip_trx_form_values_value_string );
                    
                    $tmp_value = array_merge($tmp_value,$arr);

                }

                $tmp_array[] = $tmp_value;  
                $tmp_users[] = $user;

            }

        }

        if(count($tmp_array) && is_object($site_config) 
                && $site_config->sip_trx_site_configs_trf_type == 'online' 
                && $site_config->sip_trx_site_configs_trf_data_type == 'bulk'){
            
            $client = new \GuzzleHttp\Client();
            
            $tmp_array = [ 'data' => $tmp_array ];

            $headers = [
                'Authorization' => $site_config->sip_trx_site_configs_key_sisdinkes
            ];

            $response = $client->request("POST", $url, [ 'body'=> $tmp_array ]);
            $response = $client->send($response, [ 'headers' => $headers ]);

            if( true == false ){
                
                foreach($tmp_users as $user){

                    // user notification
                    $input = array(

                        'sip_trx_user_notifications_user_id' => $user->user_id,
                        'sip_trx_user_notifications_text' => 'Your submission data for '.date('Y-m-d').' has been sent to Sisdinkes',
                        'sip_trx_user_notifications_type' => 'new-submission-bulk-online'

                        );

                    Sip_trx_user_notification::create($input);

                }
                

            }

        }

    }
}
