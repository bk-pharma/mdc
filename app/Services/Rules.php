<?php

namespace App\Services;

use App\Services\Contracts\RulesInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Rules implements RulesInterface
{
    public function getRules($ruleCode)
    {
        $data = ['ruleCode' => $ruleCode];

        return DB::select('CALL getDoctorByRules(:ruleCode);', $data);
    }

    public function getRuleDetails($column, $value, $column1, $value1)
    {
    	$data = [
    		'column' => $column,
    		'value' => $value,
    		'column1' => $column1,
    		'value1' => $value1
    	];

    	return DB::select('CALL getDoctorByRuleDetails(:column, :value, :column1, :value1);', $data);
    }

    public function getRulesSanitation($mdName)
    {
        $data = ['mdName' => $mdName];

        return DB::select('CALL getDoctorByRulesSanitation(:mdName);', $data);
    }

    public function applyRules($rawId, $rawStatus, $mdName, $correctedName, $universe, $mdCode)
    {
        $data = [
            'rawId' => $rawId,
            'rawStatus' => $rawStatus,
            'mdName' => $mdName,
            'correctedName' => $correctedName,
            'universe' => $universe,
            'mdCode' => $mdCode,
        ];

        return DB::select('CALL applyRules(:rawId, :rawStatus, :mdName, :correctedName, :universe, :mdCode);', $data);
    }
}