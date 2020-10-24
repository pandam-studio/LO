<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Pengajuan;
use App\Jobs\SDReminderJob;
use Carbon\Carbon;
class DailyEmailReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:cek';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek status timeout -7 days';

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
        $sevenDayReminder = Pengajuan::with('Status','Alumni')->
        whereDate('Tgl_masuk','<=', Carbon::now()->subDays(23)->toDateTimeString())->
        where('Tgl_keluar',null)->get();
        foreach($sevenDayReminder as $s){
            $emailJob = (new SDReminderJob(
                $s->Alumni->Id_alumni,
                $s->Code,
                $s->Status->Id_status));
            dispatch($emailJob);
        }
    }
}
