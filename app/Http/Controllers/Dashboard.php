<?php

namespace App\Http\Controllers;

use App\Services\Contracts\RawDataInterface;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Services\Contracts\ManualSanitationInterface;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Support\Facades\Validator;
use App\Exports\ImportErrorsExport;
use Maatwebsite\Excel\Facades\Excel;

class Dashboard extends Controller
{
    private $raw_data;
    private $unsanitized_data;
    private $fileName;

    function __construct(
        RawDataInterface $raw_data,
        ManualSanitationInterface $unsanitized_data
    ) {
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

    public function importNow(Request $req)
    {
        $this->raw_data->deleteImportErrors();

        $headings = (new HeadingRowImport)->toArray($req->file('rawExcel'));

        $excelHeader = [
            'branch_code' => $headings[0][0][0],
            'transact_date' => $headings[0][0][1],
            'md_name' => $headings[0][0][2],
            'ptr' => $headings[0][0][3],
            'address' => $headings[0][0][4],
            'item_code' => $headings[0][0][5],
            'item_name' => $headings[0][0][6],
            'qty' => $headings[0][0][7],
            'amount' => (isset($headings[0][0][8])) ? $headings[0][0][8] : null
        ];

        $validator = Validator::make($excelHeader,
            [
                'branch_code' => 'required',
                'transact_date' => 'required',
                'md_name' => 'required',
                'ptr' => 'required',
                'address' => 'required',
                'item_code' => 'required',
                'item_name' => 'required',
                'qty' => 'required',
                'amount' => 'required'
            ],
            [
                'branch_code.required' => 'branch_code is missing at A1',
                'transact_date.required' => 'transact_date is missing at B1',
                'md_name.required' => 'md_name is missing at C1',
                'ptr.required' => 'ptr is missing at D1',
                'address.required' => 'address is missing at E1',
                'item_code.required' => 'item_code is missing at F1',
                'item_name.required' => 'item_name is missing at G1',
                'qty.required' => 'qty is missing at H1',
                'amount.required' => 'amount is missing at I1'

            ]
        )->validate();

        $this->validate($req,['rawExcel' => 'required'],['rawExcel.required' => 'There is no file to upload.']);

        $fileName = $req->file('rawExcel')->getClientOriginalName();
        $file = $req->file('rawExcel')->storeAs('rawData', $fileName);

        $process = Process::fromShellCommandline("./bash/import.sh '".$fileName."'");
        $process->setWorkingDirectory(base_path());
        $process->setTimeout(3600);
        $process->start();

        while ($process->isRunning())
        {
            $process->checkTimeout();
            usleep(200000);
        }

        $data = array(
            'message' => 'done.'
        );

        return response()->json($data);
    }

    public function importProgress(Request $req)
    {
        if($req->has('fileName'))
        {
            $fileName = $req->input('fileName');
            $this->fileName = $req->input('fileName');

            $file = '/rawData/'.$fileName;
            $exists = Storage::disk('local')->exists($file);

            if($exists)
            {
                $process = trim($this->raw_data->isProcessRunning('import'));
                $processTotal = 0;

                if (is_numeric($process)) {
                    $processTotal = ((int) $process - 2);
                }

                if($processTotal === 0) unlink(storage_path('app/uploads/rawData/'.$fileName));

                return response()->json(
                    array(
                    'totalRaw' => $this->raw_data->getAllRawData()[0]->totalData,
                    'file' => 1,
                    'processTotal' => $processTotal,
                    'errors' => $this->raw_data->getImportErrors()
                    )
                );

            }else
            {
                return response()->json(
                    array(
                    'totalRaw' => $this->raw_data->getAllRawData()[0]->totalData,
                    'file' => 0,
                    'processTotal' => 0,
                    'errors' => $this->raw_data->getImportErrors()
                    )
                );
            }
        }else
        {
            return response()->json(
                array(
                'totalRaw' => $this->raw_data->getAllRawData()[0]->totalData,
                'file' => 0,
                'processTotal' => $processTotal,
                'errors' => $this->raw_data->getImportErrors()
                )
            );
        }
    }

    public function getImportErrors()
    {
        return $this->raw_data->getImportErrors();
    }

    public function exportImportErrors()
    {
        return Excel::download(new ImportErrorsExport, 'import errors ('.date('Y-m-d').').xlsx');
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

        if($totalUnsanitize > 700000 && $totalUnsanitize <= 800000)
        {
            $process = Process::fromShellCommandline('./bash/sanitize-80k.sh');
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
        $process = Process::fromShellCommandline('ps aux --no-heading | grep sanitize | wc -l');
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
