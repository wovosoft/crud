<?php

namespace Wovosoft\Crud\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud
                            {--i|interactive : Interactive mode}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to make CRUD individual commands using Console/GUI';

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
        $type = $this->getCommand(null);
        $this->call("crud:" . $type, [
            "-i" => true
        ]);
        if ($this->choice("Do you want to run mode Commands?", [
                "YES",
                "NO"
            ], 0) == "YES") {
            $this->call("crud", [
                "-i" => true
            ]);
        }
    }

    protected function getCommand($default = null)
    {
        return $default ?? $this->choice(
                'What do you want to generate?',
                [
                    "make_package",
                    "remove_package",
                    "make_model",
                    "remove_model",
                    "make_controller",
                    "remove_controller",
                ], 0);
    }
}
