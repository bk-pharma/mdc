<?php

namespace App\Http\Controllers;

use App\Services\Contracts\RawDataInterface;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Services\Contracts\ManualSanitationInterface;
use Symfony\Component\Process\Process;

class Dashboard extends Controller
{
    private $raw_data;
    private $unsanitized_data;


    function __construct(RawDataInterface $raw_data, ManualSanitationInterface $unsanitized_data)
    {
        $this->raw_data = $raw_data;
        $this->unsanitized_data = $unsanitized_data;

    }

    public function index()
    {
        echo 'Unauthorized';
    }

    public function import()
    {
        return view('import.index');
    }

    public function sanitation()
    {
        return view('sanitation.index');
    }

    public function sanitationProcess($rowStart, $rowCount)
    {
        $process = Process::fromShellCommandline('php artisan sanitize --row_start='.$rowStart.' --row_count='.$rowCount);
        $process->setWorkingDirectory(base_path());
        $process->setTimeout(3600);
        $process->start();

        while ($process->isRunning()) {
            // waiting for process to finish
        }

        $process = trim($this->isSanitationProcessRunning());
        $processTotal = 0;

        if (is_numeric($process)) {
            $processTotal = ((int) $process - 2);
        }

        $data = [
            'totalRaw' => $this->raw_data->getAllRawData()[0]->totalData,
            'totalSanitized' => $this->raw_data->getSanitizedCount()[0]->totalSanitized,
            'totalAmount' => $this->raw_data->getSanitizedCount()[0]->totalAmount,
            'sanitationProcess' => $processTotal
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
            $processTotal = ((int) $process - 2);
        }

        $data = [
        'totalRaw' => $this->raw_data->getAllRawData()[0]->totalData,
        'totalSanitized' => $this->raw_data->getSanitizedCount()[0]->totalSanitized,
        'totalAmount' => $this->raw_data->getSanitizedCount()[0]->totalAmount,
        'sanitationProcess' => $processTotal,
        ];

        return response()->json($data);
    }

    public function resetData()
    {
        $this->raw_data->resetData();

        $data = [
        'totalRaw' => $this->raw_data->getAllRawData()[0]->totalData,
        'totalSanitized' => $this->raw_data->getSanitizedCount()[0]->totalSanitized,
        'totalAmount' => $this->raw_data->getSanitizedCount()[0]->totalAmount
        ];

        return response()->json($data);
    }
    public function manual()
    {
        return view('manual.manual');
    }

    public function uncleanedData()
    {
        return view('manual.uncleanedData');
    }

    public function getUnsanitizedData(){

        return $this->unsanitized_data->getUnsanitizedData();

    }

    public function getCorrectedName(Request $req)
    {
        $corrected_name = $req->input('corrected_name');
        return response()->json($this->unsanitized_data->getCorrectedName($corrected_name));
    }
}

