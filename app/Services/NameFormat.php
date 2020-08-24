<?php

namespace App\Services;

use App\Services\Contracts\NameFormatInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NameFormat implements NameFormatInterface
{

    private $unclassified = [
        'HOSPITAL',
        'HOSP',
        'CLINIC',
        'CLINICS',
        'MEDICAL',
        'CENTER',
        'OSPITAL'
    ];

    private $lastNameMultiple = [
    	'De',
    	'Delos',
    	'Dela',
    	'Del'
    ];

    /*
    	https://stackoverflow.com/questions/19445798/check-if-string-contains-a-value-in-array
    */
    public function isUnclassified($value)
    {
		foreach ($this->unclassified as $unclassified)
		{
		    if (stripos($value, $unclassified) !== FALSE)
		    {
		        return true;
		    }
		}

		return false;
    }

    /*
    	https://stackoverflow.com/questions/19445798/check-if-string-contains-a-value-in-array
    */
    public function isLastNameMultiple($value)
    {
		foreach ($this->lastNameMultiple as $lastNameMultiple)
		{
		    if (stripos($value, $lastNameMultiple) !== FALSE)
		    {
		        return true;
		    }
		}

		return false;
    }

    public function formatName($rawId, $mdName, $correctedName, $sanitizedBy)
    {
    	$data = [
    		'rawId' => $rawId,
    		'mdName' => $mdName,
    		'correctedName' => $correctedName,
            'sanitizedBy' => $sanitizedBy
    	];

    	return DB::select('CALL formatName(:rawId, :mdName, :correctedName, :sanitizedBy);', $data);
    }
}