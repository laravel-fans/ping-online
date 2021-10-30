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
        $logs = ['not support Windows'];
        if (PHP_OS_FAMILY == 'Windows') {
            return view('welcome', compact('logs', 'host'));
        }
        $logs = [];
        $bin = PHP_OS_FAMILY == 'Darwin' ? '/sbin/ping' : '/bin/ping';
        $process = new Process([
            $bin,
            '-c',
            '3',
            $host
        ]);
        $process->start();

        foreach ($process as $type => $data) {
            $lines = explode("\n", $data);
            foreach ($lines as $line) {
                $logs[] = trim($line);
            }
        }

        return view('welcome', compact('logs', 'host'));
    }
}
