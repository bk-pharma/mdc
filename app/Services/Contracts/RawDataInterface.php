<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

Interface RawDataInterface
{
	public function getRawData($rowStart, $rowCount);

	public function getAllRawData();

	public function getSanitizedCount();

	 public function getAllUnsanitize();

	public function setAsUnidentified($rawId, $sanitizedBy);

	public function getImportTagging($branchCode);

	public function getProductName($productCode);
}