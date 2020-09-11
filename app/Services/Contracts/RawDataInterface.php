<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

Interface RawDataInterface
{
	public function add($dataArr);

	public function getRawData($rowStart, $rowCount);

	public function getTotalImported($fileName);

	public function addImportError($errorArr);

	public function getImportErrors();

	public function deleteImportErrors();

	public function getAllRawData();

	public function getSanitizedCount();

	public function getRawDataById($id);

	public function getAllUnsanitize();

	public function setAsUnidentified($rawId, $sanitizedBy);

	public function getImportTagging($branchCode);

	public function getProductName($productCode);

	public function isProcessRunning($process);
}