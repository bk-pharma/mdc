<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Contracts\RawDataInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Dashboard extends Controller
{

    private $raw_data;

    function __construct(RawDataInterface $raw_data)
    {
        $this->raw_data = $raw_data;
    }

    public function index()
    {
        echo 'Unauthorized';
    }

    public function sanitation()
    {
        return view('sanitation.index');
    }

    public function sanitationProcess(Request $req)
    {
        $rowStart = $req->input('rowStart');
        $rowCount = $req->input('rowCount');

        $process = Process::fromShellCommandline('php artisan sanitize --row_start=' . $rowStart . ' --row_count=' . $rowCount);
        $process->setWorkingDirectory(base_path());
        $process->setTimeout(3600);
        $process->start();

        $process->wait();

        $data = [
        'totalRaw' => $this->raw_data->getAllRawData()[0]->totalData,
        'totalSanitized' => $this->raw_data->getSanitizedCount()[0]->totalSanitized,
        'totalAmount' => $this->raw_data->getSanitizedCount()[0]->totalAmount,
        ];

        return response()->json($data);
    }

    private function isSanitationProcessRunning()
    {
        $process = Process::fromShellCommandline('ps aux --no-heading | grep artisan | wc -l');
        $process->setWorkingDirectory(base_path());

        try {
            $process->mustRun();
            return $process->getOutput();
        } catch (ProcessFailedException $exception) {
            echo $exception->getMessage();
        }
    }

    public function getSanitizedCount()
    {

        $process = trim($this->isSanitationProcessRunning());
        $processTotal = 0;

        if (is_numeric($process)) {
            $processTotal = ((int)$process - 2);
        }

        $data = [
        'totalRaw' => $this->raw_data->getAllRawData()[0]->totalData,
        'totalSanitized' => $this->raw_data->getSanitizedCount()[0]->totalSanitized,
        'totalAmount' => $this->raw_data->getSanitizedCount()[0]->totalAmount,
        'sanitationProcess' => $processTotal
        ];

        return response()->json($data);
    }
}
