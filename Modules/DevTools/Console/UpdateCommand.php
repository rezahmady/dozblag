<?php

namespace Modules\DevTools\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:release {commit : The ID of the commit} {version : version name used in zip file name} {--H|head : zip all changed files to Head}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

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
        $commit = $this->argument('commit');
        $version = $this->argument('version');
        $head = $this->option('head');

        $arguments = $this->getArguments();
        $options = $this->getOptions();

        $this->info("command info -> {$commit} | {$version} | head: {$head}");
        $this->get_new_version($commit, $version, $head);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['commit', InputArgument::REQUIRED, 'commit'],
            ['version', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['head', null, InputOption::VALUE_OPTIONAL, 'An example option.', 0],
        ];
    }

    public function get_commits(): array
    {
        $output = array();
        chdir(base_path());
        exec("git log",$output);
        $history = array();
        $commit = array();
        foreach($output as $line){
            if(strpos($line, 'commit')===0){
                if(!empty($commit)){
                    array_push($history, $commit);
                    unset($commit);
                }
                $commit['hash']   = substr($line, strlen('commit'));
            }
            else if(strpos($line, 'Author')===0){
                $commit['author'] = substr($line, strlen('Author:'));
            }
            else if(strpos($line, 'Date')===0){
                $commit['date']   = substr($line, strlen('Date:'));
            }
            else{
                if(isset($commit['message']))
                    $commit['message']  .= $line;
                else
                    $commit['message']  = $line;

            }
        }

        return $history;
    }

    public function get_changed_files($commit_id): array
    {
        $files = [];
        chdir(base_path());
        exec("git diff-tree --no-commit-id --name-only -r ".$commit_id,$output);
        foreach($output as $line){
            if(file_exists(base_path($line)))
                array_push($files, $line);
        }

        return $files;
    }

    public function get_new_version($commit, $version, $head = false)
    {
        $commits = $this->get_commits();
        $files = [];
        $key = $this->searchForCommit($commit, $commits);
        if($head) {
            for ($i=0; $i <= $key; $i++) {
                $files = array_merge($files, $this->get_changed_files($commits[$i]['hash']));
            }
        } else {
            if($key !== null) {
                $files = $this->get_changed_files($commit);
            }
        }

        if(sizeof($files)) {
            $files = implode(' ', array_unique($files));
            chdir(base_path());
            exec("tar.exe -a -c -f ".storage_path("/app/releases/cms-v".$version.".zip")." ".$files,$output);
            $this->info('successful! file: '.storage_path("\app\cms-v".$version.".zip"));
        } else {
            $this->error('no file exist!');
        }
    }

    public function searchForCommit($hash, $commits) {
        foreach ($commits as $key => $commit) {
            if (strpos($commit['hash'], $hash)) {
                return $key;
            }
        }
        return null;
    }
}
