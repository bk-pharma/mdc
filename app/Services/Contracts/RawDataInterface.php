<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

Interface RawDataInterface
{
	public function add(
		$raw_year,
		$raw_quarter,
		$raw_month,
		$raw_status,
		$raw_lbucode,
		$raw_lburebate,
		$raw_date,
		$raw_branchcode,
		$raw_branchname,
		$raw_doctor,
		$raw_corrected_name,
		$raw_license,
		$raw_address,
		$raw_productcode,
		$raw_productname,
		$raw_qtytab,
		$raw_qtypack,
		$raw_amount,
		$raw_district,
		$raw_sarcode,
		$raw_sarname,
		$raw_samcode,
		$raw_samname,
		$raw_hospcode,
		$raw_hospname,
		$raw_hdmcode,
		$raw_hdmname,
		$raw_kasscode,
		$raw_kassname,
		$raw_kassmcode,
		$raw_kassmname,
		$raw_universe,
		$raw_mdcode,
		$sanitized_by,
		$orig_mdname
	);

	public function getRawData($rowStart, $rowCount);

	public function getAllRawData();

	public function getSanitizedCount();

	 public function getAllUnsanitize();

	public function setAsUnidentified($rawId, $sanitizedBy);

	public function getImportTagging($branchCode);

	public function getProductName($productCode);
}