<?php

namespace App\Services;

use App\Services\Contracts\RawDataInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class RawData implements RawDataInterface
{

    public function add($dataArr)
    {
        DB::insert('INSERT INTO sanitation_result_new (
            raw_id,
            raw_year,
            raw_quarter,
            raw_month,
            raw_status,
            raw_lbucode,
            raw_lburebate,
            raw_date,
            raw_branchcode,
            raw_branchname,
            raw_doctor,
            raw_corrected_name,
            raw_license,
            raw_address,
            raw_productcode,
            raw_productname,
            raw_qtytab,
            raw_qtypack,
            raw_amount,
            raw_district,
            raw_sarcode,
            raw_sarname,
            raw_samcode,
            raw_samname,
            raw_hospcode,
            raw_hospname,
            raw_hdmcode,
            raw_hdmname,
            raw_kasscode,
            raw_kassname,
            raw_kassmcode,
            raw_kassmname,
            raw_universe,
            raw_mdcode,
            sanitized_by,
            filename,
            orig_mdname
        ) VALUES (
            :raw_id,
            :raw_year,
            :raw_quarter,
            :raw_month,
            :raw_status,
            :raw_lbucode,
            :raw_lburebate,
            :raw_date,
            :raw_branchcode,
            :raw_branchname,
            :raw_doctor,
            :raw_corrected_name,
            :raw_license,
            :raw_address,
            :raw_productcode,
            :raw_productname,
            :raw_qtytab,
            :raw_qtypack,
            :raw_amount,
            :raw_district,
            :raw_sarcode,
            :raw_sarname,
            :raw_samcode,
            :raw_samname,
            :raw_hospcode,
            :raw_hospname,
            :raw_hdmcode,
            :raw_hdmname,
            :raw_kasscode,
            :raw_kassname,
            :raw_kassmcode,
            :raw_kassmname,
            :raw_universe,
            :raw_mdcode,
            :sanitized_by,
            :filename,
            :orig_mdname
        )', $dataArr);
    }

    public function getRawData($rowStart, $rowCount)
    {
    	$data = array(
    		'rowStart' => $rowStart,
    		'rowCount' => $rowCount
    	);

        return DB::select('CALL getDataToBeSanitized(:rowStart, :rowCount)', $data);
    }

    public function getTotalImported($fileName)
    {
        $data = ['fileName' => $fileName];

        return DB::select("
            SELECT COUNT(raw_id) as total
            FROM sanitation_result_new
            WHERE filename = :fileName
        ", $data);
    }

    public function addImportError($errorArr)
    {
        DB::insert('INSERT INTO import_errors (row_id, filename, error, branch_code, transact_date, md_name, ptr, address, item_code, item_name, qty, amount) VALUES (:rowId, :fileName, :msg, :branch_code, :transact_date, :md_name, :ptr, :address, :item_code, :item_name, :qty, :amount)', $errorArr);
    }

    public function getImportErrors()
    {
        return DB::select("
            SELECT *
            FROM import_errors
        ");
    }

    public function deleteImportErrors()
    {
        return DB::delete('DELETE FROM import_errors');
    }

    public function getAllRawData()
    {
        return DB::select("
            SELECT DISTINCT COUNT(raw_id) as totalData, ROUND(SUM(raw_amount),2) as totalAmount
            FROM sanitation_result_new
        ");
    }

    public function getSanitizedCount()
    {
        return DB::select("
            SELECT DISTINCT COUNT(raw_id) as totalSanitized, ROUND(SUM(raw_amount),2) as totalAmount
            FROM sanitation_result_new
            WHERE raw_status != ''
        ");
    }

    public function getRawDataById($id)
    {
        return DB::select("
            SELECT *
            FROM sanitation_result_new
            WHERE raw_id = :id
        ",['id' => $id]);
    }

    public function getAllUnsanitize()
    {
        return DB::select("
            SELECT DISTINCT COUNT(raw_id) as totalUnsanitize
            FROM sanitation_result_new
            WHERE raw_status = ''
        ");
    }

    public function setAsUnidentified($rawId, $sanitizedBy)
    {
        return DB::update("
            UPDATE sanitation_result_new
            SET raw_status = 'UNIDENTIFIED', sanitized_by = '".$sanitizedBy."'
            WHERE raw_id = ".$rawId
        );
    }

    public function getImportTagging($branchCode)
    {
        $data = array(
            'branchCode' => $branchCode
        );

        return DB::select("
            SELECT
                mst_branchcode,
                mst_lbucode,
                mst_lburebate,
                mst_branchname,
                mst_district,
                mst_sarcode,
                mst_sarname,
                mst_samcode,
                mst_samname,
                mst_hospcode,
                mst_hospname,
                mst_hdmcode,
                mst_hdmname,
                mst_kasscode,
                mst_kassname,
                mst_kassmcode,
                mst_kassmname
            FROM mst_database
            WHERE mst_branchcode = :branchCode
        ", $data);
    }

    public function getProductName($productCode)
    {
        $data = array(
            'productCode' => $productCode
        );

        return DB::select("
            SELECT prod_name, prod_packsize, prod_pertab
            FROM mst_productdb
            WHERE prod_code = :productCode
        ", $data);
    }

    public function isProcessRunning($process)
    {
        $process = Process::fromShellCommandline('ps aux --no-heading | grep '.$process.' | wc -l');
        $process->setWorkingDirectory(base_path());

        try {
            $process->mustRun();

            return $process->getOutput();
        } catch (ProcessFailedException $exception) {
            echo $exception->getMessage();
        }
    }
}