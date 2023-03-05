<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GetWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getWeather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Weather of Users using API.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //
        $users = User::get();

        if($users->isEmpty()){
            $this->warn('No users');

            return;
        }

        foreach($users as $user){
            $latitude = $user->latitude;
            $longitude = $user->longitude;

            $apiToken = env('API_TOKEN');
            $apiUrl = env('API_URL').'?lat='.$latitude.'&lon='.$longitude.'&appid='.$apiToken;

            $response = Http::get($apiUrl);
            $jsonData = $response->json();

            if($jsonData){
                try {
                    $user->weather = json_encode($jsonData);
                    $user->save();
                    
                    $this->info($user->name.' is updated.');

                } catch(Throwable $e){
                    
                }
            }
            
        }
    }
    
}
