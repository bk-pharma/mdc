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

    public function getRuleDetailsTriple($column, $value, $column1, $value1, $column2, $value2)
    {
        $data = [
            'column' => $column,
            'value' => $value,
            'column1' => $column1,
            'value1' => $value1,
            'column2' => $column2,
            'value2' => $value2
        ];

        return DB::select('CALL getDoctorByRuleDetailsTriple(:column, :value, :column1, :value1, :column2, :value2);', $data);
    }

    public function getRulesSanitation($mdName)
    {
        $data = ['mdName' => $mdName];

        return DB::select('CALL getDoctorByRulesSanitation(:mdName);', $data);
    }

    public function getDocNameFromRuleTbl($ruleCode)
    {
        $data = array(
            'ruleCode' => $ruleCode
        );

        return DB::select('SELECT rule_assign_to FROM rules_tbl WHERE rule_code = :ruleCode', $data);
    }

    public function applyRules($rawId, $rawStatus, $mdName, $correctedName, $universe, $mdCode, $sanitizedBy)
    {
        $data = [
            'rawId' => $rawId,
            'rawStatus' => $rawStatus,
            'mdName' => $mdName,
            'correctedName' => $correctedName,
            'universe' => $universe,
            'mdCode' => $mdCode,
            'sanitizedBy' => $sanitizedBy
        ];

        return DB::select('CALL applyRules(:rawId, :rawStatus, :mdName, :correctedName, :universe, :mdCode, :sanitizedBy);', $data);
    }
}