<?php

namespace App\Http\Controllers;

use App\Services\Contracts\RawDataInterface;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Services\Contracts\ManualSanitationInterface;
use Symfony\Component\Process\Process;
use Maatwebsite\Excel\Excel;
use App\Imports\RawDataImport;

class Dashboard extends Controller
{
    private $raw_data;
    private $unsanitized_data;
    private $excel;

    function __construct(
        RawDataInterface $raw_data,
        ManualSanitationInterface $unsanitized_data,
        Excel $excel
    ) {
        $this->raw_data = $raw_data;
        $this->unsanitized_data = $unsanitized_data;
        $this->excel = $excel;
    }

    public function index()
    {
        echo 'Unauthorized';
    }

    public function import()
    {
        return view('import.index');
    }

    public function importNow(Request $req)
    {
        $this->validate(
            $req,
            ['rawExcel' => 'required'],
            ['rawExcel.required' => 'There is no file to upload.']
        );

        $fileName = $req->file('rawExcel')->getClientOriginalName();
        $file = $req->file('rawExcel')->storeAs('rawData', $fileName);

        $process = Process::fromShellCommandline('php artisan import --file_name='.$fileName);
        $process->setWorkingDirectory(base_path());
        $process->setTimeout(3600);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $data = array(
            'message' => 'done.'
        );

        return response()->json($data);
    }


    public function sanitation()
    {
        return view('sanitation.index');
    }

    public function sanitationProcess()
    {
        $totalUnsanitize = $this->raw_data->getAllUnsanitize()[0]->totalUnsanitize;


        if($totalUnsanitize <= 10000)
        {
            $process = Process::fromShellCommandline('./bash/sanitize-1k.sh');
        }

        if( $totalUnsanitize > 10000 && $totalUnsanitize <= 100000)
        {
            $process = Process::fromShellCommandline('./bash/sanitize-10k.sh');
        }

        if($totalUnsanitize > 100000 && $totalUnsanitize <= 200000)
        {
            $process = Process::fromShellCommandline('./bash/sanitize-20k.sh');
        }

        if($totalUnsanitize > 200000 && $totalUnsanitize <= 300000)
        {
            $process = Process::fromShellCommandline('./bash/sanitize-30k.sh');
        }

        if($totalUnsanitize > 300000 && $totalUnsanitize <= 400000)
        {
            $process = Process::fromShellCommandline('./bash/sanitize-40k.sh');
        }

        if($totalUnsanitize > 400000 && $totalUnsanitize <= 500000)
        {
            $process = Process::fromShellCommandline('./bash/sanitize-50k.sh');
        }

        if($totalUnsanitize > 500000 && $totalUnsanitize <= 600000)
        {
            $process = Process::fromShellCommandline('./bash/sanitize-60k.sh');
        }

        if($totalUnsanitize > 600000 && $totalUnsanitize <= 700000)
        {
            $process = Process::fromShellCommandline('./bash/sanitize-70k.sh');
        }

        if($totalUnsanitize > 800000 && $totalUnsanitize <= 900000)
        {
            $process = Process::fromShellCommandline('./bash/sanitize-80k.sh');
        }

        if($totalUnsanitize > 900000)
        {
            $process = Process::fromShellCommandline('./bash/sanitize-100k.sh');
        }

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

    public function getAllRawData()
    {
        $data = [
            'totalRaw' => $this->raw_data->getAllRawData()[0]->totalData
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

    public function getUnsanitizedData()
    {

        return $this->unsanitized_data->getUnsanitizedData();
    }

    public function getCorrectedName(Request $req)
    {
        $corrected_name = $req->input('corrected_name');
        return response()->json($this->unsanitized_data->getCorrectedName($corrected_name));
    }
}
