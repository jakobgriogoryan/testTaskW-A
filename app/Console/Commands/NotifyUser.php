<?php

namespace App\Console\Commands;

use App\Models\Item;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class NotifyUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $toDos = Item::all();
        $expDate = Carbon::now()->addDay(1)->addMinute(15)->format('Y-m-d H:i:s');
        $user = User::first();

        foreach($toDos as $toDo) {
            $details = [
                'greeting' => $user->full_name,
                'body' => 'Your ToDo item would be expired at '. $toDo->expiration_date,
                'thanks' => 'Thank you.',
            ];
            if($expDate == $toDo->expiration_date) {
                $user->notify(new \App\Notifications\NotifyUser($details));
            }

        }
    }
}
