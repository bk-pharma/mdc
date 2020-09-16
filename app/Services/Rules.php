<?php

namespace App\Services;

use App\Services\Contracts\RulesInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Rules implements RulesInterface
{
    public function generateRuleCode()
    {
        $ruleCode = date('YmdHis');

        $getRule = DB::select('SELECT rule_id FROM rules_tbl WHERE rule_code = :ruleCode',['ruleCode' => $ruleCode]);

        if(count($getRule) > 0)
        {
            $this->generateRuleCode();
        }else
        {
            return $ruleCode;
        }

    }

    public function add($rulesArr)
    {
        $ruleCode = $this->generateRuleCode();

        $ruleTbl = [
            'ruleCode' => $ruleCode,
            'ruleAssignTo' => $rulesArr[0]['value'],
            'createdBy' => 2,
            'status' => 1
        ];

        DB::insert('INSERT INTO rules_tbl (rule_code, rule_assign_to, rule_created_by, status) VALUES (:ruleCode, :ruleAssignTo, :createdBy, :status)', $ruleTbl);

        $i = 0;
        $len = count($rulesArr);
        $markedAsEnd = '';
        $markedAsEndOperator = 'and';

        foreach($rulesArr as $rule)
        {
            if ($i == $len - 1)
            {
                $markedAsEndOperator = '';
                $markedAsEnd = '         x';
            }

            if($rule['column'] !== 'raw_mdcode')
            {
                $this->details($ruleCode, $rule['column'], '=' , $rule['value'].$markedAsEnd, $markedAsEndOperator);
            }

            $i++;
        }

        $resp = [
            'ruleCode' => $ruleCode,
            'message' => 'rule added.'
        ];

        return $resp;
    }

    public function details($ruleCode, $column, $operator, $value, $condition)
    {
        $data = [
            'ruleCode' => $ruleCode,
            'column' => $column,
            'operator' => $operator,
            'value' => $value,
            'condition' => $condition
        ];

        DB::insert('INSERT INTO rules_details (rule_code, details_column_name, details_value_optr, details_value, details_condition_optr) VALUES (:ruleCode, :column, :operator, :value, :condition)', $data);
    }

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