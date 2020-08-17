<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Contracts\RawDataInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Services\Contracts\ManualSanitationInterface;
use Symfony\Component\Process\Process;
use DB;
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

    public function sanitationProcess(Request $req)
    {
        $rowStart = $req->input('rowStart');
        $rowCount = $req->input('rowCount');

        $process = Process::fromShellCommandline('php artisan sanitize --row_start=' . $rowStart . ' --row_count=' . $rowCount);
        $process->setWorkingDirectory(base_path());
        $process->setTimeout(3600);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

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
    public function manual()
    {
        return view('manual.manual');
    }

    public function uncleanedData()
    {
        $count = $this->getSanitizedCount1();
        $sanitizedTotalCount = $this->sanitizedTotalCount();
        return view('manual.uncleanedData')
                ->with('count', $count)
                ->with('sanitizedTotalCount', $sanitizedTotalCount);
    }

    public function getUnsanitizedData(){
        
        return $this->unsanitized_data->getUnsanitizedData();
        
    }

    public function getCorrectedName(Request $req)
    {
        $corrected_name = $req->input('corrected_name');
        return response()->json($this->unsanitized_data->getCorrectedName($corrected_name));
    }

    public function getSanitizedCount1(){
        $count =  DB::select("
            SELECT 
                 COUNT(raw_status) as Total
            FROM 
                sanitation_result1 
            WHERE 
                raw_status != ''
        ");
        return $count;
     

    }

    public function sanitizedTotalCount(){
        $sanitizedTotalCount =  DB::select("
        SELECT
            COUNT(raw_status) as TotalCount
         FROM
             sanitation_result1
         WHERE 
                raw_status = ''            
        ");
        return $sanitizedTotalCount;

    }
}

