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
        $host = $request->input('host');
        $logs = [];
        if (empty($host)) {
            $host = 'example.com';
            return view('welcome', compact('logs', 'host'));
        }

        if (PHP_OS_FAMILY == 'Windows') {
            $logs = ['not support Windows'];
            return view('welcome', compact('logs', 'host'));
        }

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
