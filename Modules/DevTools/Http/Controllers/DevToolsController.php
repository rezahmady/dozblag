<?php

namespace Modules\DevTools\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DevToolsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('devtools::index');
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
            array_push($files, $line);
        }

        return $files;
    }

    public function get_new_version($from_commit_id, $version, $to_now = false) {
        $commits = $this->get_commits();
        $files = false;
        $key = array_search($from_commit_id, $commits);
        if($to_now) {
            for ($i=0; $i <= $key; $i++) {
                $files = $this->get_changed_files($commits[$i]['hash']);
            }
        } else {
            if($key !== false) {
                $files = $this->get_changed_files($from_commit_id);
            }
        }

        if($files) {
            chdir(base_path());
            exec("tar.exe -a -c -f /storage/app/update-exports/cms-v".$version.".zip ".$files,$output);
        }
    }

    public function test($user) {
        return $this->info("Sending email to: {$user}!");
    }
}
