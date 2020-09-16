<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

Interface RulesInterface
{
	public function generateRuleCode();

	public function add($rulesArr);

	public function details($ruleCode, $column, $operator, $value, $condition);

	public function getRules($ruleCode);

	public function getRuleDetails($columns, $value, $columns1, $value1);

	public function getRuleDetailsTriple($columns, $value, $columns1, $value1, $columns2, $value2);

	public function getRulesSanitation($mdName);

	public function applyRules($rawId, $rawStatus, $mdName, $correctedName, $universe, $mdCode);

}