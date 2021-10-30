<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class WelcomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $host = $request->input('host', 'example.com');
        $process = new Process([
            '/sbin/ping',
            '-c',
            '3',
            $host
        ]);
        $process->start();

        $logs = [];
        foreach ($process as $type => $data) {
            $lines = explode("\n", $data);
            foreach ($lines as $line) {
                $logs[] = trim($line);
            }
        }

        return view('welcome', compact('logs', 'host'));
    }
}
