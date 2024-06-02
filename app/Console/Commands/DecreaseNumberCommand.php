<?php

namespace App\Console\Commands;
use App\Models\Project;
use Illuminate\Console\Command;

class DecreaseNumberCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'decrease:number';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Decrease the number after 24 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        $projects = Project::get();
        foreach ($projects as $project) {
            $project->end_date -=1;
            $project->save();
            $this->info('Number decreased successfully!');
        }
    }
}
