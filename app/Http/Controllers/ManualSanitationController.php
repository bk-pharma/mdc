<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Config;
use App\Services\Contracts\RulesInterface;
use App\Services\Contracts\RawDataInterface;
use Pusher\Pusher;
use App\Events\RealtimeSanitationEvent;
use App\Sanitize;
use App\Checking;
use App\Doctor;
use App\User;
use DB;
use Auth;
use Avatar;
use App\RulesDetails as Details;
use App\RulesTable as RTables;

class ManualSanitationController extends Controller
{

    private $raw_data;
    private $rules;

	public function __construct(RulesInterface $rules, RawDataInterface $raw_data)
    {

        /* $this->middleware('auth'); */
        $this->raw_data = $raw_data;
        $this->rules = $rules;
    }
    public function getSelected(){
        $selected = Checking::with('user')->get();
        
        
        foreach($selected as $key => $select){

            $avatar[] = Avatar::create($select->user->auth_fullname)
                                ->setBackground($this->colourBrightness($select->user->tag_color, -0.5))
                                ->setDimension(20, 20)
                                ->setfontSize(10)
                                ->toSvg();
        }
            
        if(count($selected) > 0){
            
            $data = [
                'status' => true,
                'checked' => 'filter',
                'count' => count($selected),
                'selected' => $selected,
                'avatar' => $avatar
    
            ];
            
        }else{
            
            $data = [
                'status' => true,
                'checked' => 'filter',
                'count' => count($selected),
                'selected' => $selected
    
            ];
        }
        
        broadcast(new RealtimeSanitationEvent($data))->toOthers();
        return response()->json($selected);
    }

	public function getManualSanitation() {

        $sanitizeRow = Sanitize::where('raw_status', '!=', '')->count();
        $unsanitizeRow = Sanitize::where('raw_status', '=', '')->count();

		$user = Auth::user();
		return view('manual.manual_sanitation')
        ->with('user', $user)
        ->with('sanitizeRow', $sanitizeRow)
        ->with('unsanitizeRow', $unsanitizeRow);
	}

	public function getSanitationData(){
        $unsanitize = Sanitize::with('checking')->select('raw_id',
	                    'raw_doctor',
                        'raw_corrected_name',
                        'raw_status',
	                    'raw_license',
	                    'raw_address',
	                    'raw_branchname',
	                    'raw_lbucode',
	                    'raw_amount',
	                    'sanitized_by',
	                    'date_sanitized',
                        DB::raw('COUNT(raw_id) as raw_row_count'),
                        DB::raw('SUM(raw_amount) as raw_total_amount'))
                        ->limit(500)
	                ->groupBy([
	                    'raw_doctor',
	                    'raw_license',
	                    'raw_branchname',
	                    'raw_address'
                    ]);

        return DataTables::of($unsanitize)
            ->setRowClass('sanitize-tr')
            ->setRowAttr([

                'id' => function($unsanitize) {
                    return 'trRow-'.$unsanitize->raw_id;
                },
                'style' => function($unsanitize) {

                    if($unsanitize->raw_status != ''){

                        if(Auth::user()->auth_role == "TEAM LEADER" || Auth::user()->auth_role == "ADMIN"){
                            
                            if($unsanitize->checking){

                                if($unsanitize->checking->user->auth_id == Auth::user()->auth_id){
                                    $pointer = 'pointer-events: auto; cursor: pointer;';
                                }else{
                                    $pointer = 'pointer-events: none; cursor: not-allowed !important;';
                                }
                                
                                $opacity = ($unsanitize->checking->user->auth_id == Auth::user()->auth_id) ? 0.8 : 0.5;
        
                                return 'background-color: '.$this->colourBrightness($unsanitize->checking->user->tag_color, $opacity).'; '.$pointer;
                            }else{
                                return 'background-color: #fff; pointer-events: auto; cursor: pointer;';
                            }
                        
                        }else{
    
                            return 'background-color: #fff; pointer-events: none; cursor: not-allowed !important;';
                        }
    
                    }else{
                        
                        if($unsanitize->checking){

                            if($unsanitize->checking->user->auth_id == Auth::user()->auth_id){
                                $pointer = 'pointer-events: auto; cursor: pointer;';
                            }else{
                                $pointer = 'pointer-events: none; cursor: not-allowed !important;';
                            }
                            
                            $opacity = ($unsanitize->checking->user->auth_id == Auth::user()->auth_id) ? 0.8 : 0.5;
    
                            return 'background-color: '.$this->colourBrightness($unsanitize->checking->user->tag_color, $opacity).'; '.$pointer;
                        }else{
                            return 'background-color: #fff; pointer-events: auto; cursor: pointer;';
                        }
                        
                    }
                   
                }
            ])
            ->addColumn('raw_image', function ($unsanitize) {

                if($unsanitize->checking){

                    $image = Avatar::create($unsanitize->checking->user->auth_fullname)
                                ->setBackground($this->colourBrightness($unsanitize->checking->user->tag_color, -0.3))
                                ->setDimension(20, 20)
                                ->setfontSize(10)
                                ->toSvg();

                }else{

                    $image = '';
                }

                return '<span id="row-'.$unsanitize->raw_id.'">'.$image.'</span>';
            })
            ->addColumn('raw_check', function ($unsanitize) {

                $checked = $unsanitize->checking ? 'value="'.$unsanitize->raw_id.'" checked' : '';

                $readonly = $unsanitize->checking ? (($unsanitize->checking->user_id == Auth::user()->auth_id) ? '' : 'readonly' ) : '';

                $selected = $unsanitize->checking ? (($unsanitize->checking->user_id == Auth::user()->auth_id) ? 'selected selected-check-'.Auth::user()->auth_id : '' ) : '';
                
                $notselected = $unsanitize->checking ? '' : 'not-selected';
                
                $value = $unsanitize->checking ? $unsanitize->raw_id : '';
                
                if($unsanitize->raw_status != ''){

                    if(Auth::user()->auth_role == "TEAM LEADER" || Auth::user()->auth_role == "ADMIN"){
                        
                        $disabledCheckbox = '';
                    
                    }else{

                        $disabledCheckbox = 'disabled';
                    }

                }else{

                    $disabledCheckbox = '';
                }
                
                return '<center>
                            <input type="checkbox" name="sanitize[]" id="select-sanitize" class="checkbox-'.$unsanitize->raw_id.' '.$selected.' '.$notselected.'" value="'.$value.'" data-id="'.$unsanitize->raw_id.'" '.$checked.' '.$readonly.' '.$disabledCheckbox.'>
                        </center>';
                
            })
            ->addColumn('raw_id', function($unsanitize){
                return $unsanitize->raw_id;
            })
            ->addColumn('raw_doctor', function($unsanitize){
                return $unsanitize->raw_doctor;
            })
            ->addColumn('raw_button', function($unsanitize){
                if($unsanitize->raw_status != ''){
                    return '<span class="sanitize_assign_md_'.$unsanitize->raw_id.'"><span class="pull-left">'.$unsanitize->raw_corrected_name.'</span>'.'<a href="#" class="pull-right" id="editButton"> <i class="nav-icon fas fa-edit"></i></a></span>';
                } else {
                    return '<span class="sanitize_assign_md_'.$unsanitize->raw_id.'"><button class="sanitize_button_td btn btn-primary btn-xs sanitize-btn-'.$unsanitize->raw_id.'" name="raw_button" id="assignButton" id="sanitizeOne" onclick="sanitizeOne('.$unsanitize->raw_id.')" data-id="'.$unsanitize->raw_id.'"> Sanitize </button></span>';
                }
            })
            ->addColumn('raw_status', function($unsanitize){
                return $unsanitize->raw_status;
            })
            ->addColumn('raw_license', function($unsanitize){
                return $unsanitize->raw_license;
            })
            ->addColumn('raw_address', function($unsanitize){
                return $unsanitize->raw_address;
            })
            ->addColumn('raw_branchname', function($unsanitize){
                return $unsanitize->raw_branchname;
            })
            ->addColumn('raw_lbucode', function($unsanitize){
                return $unsanitize->raw_lbucode;
            })
            ->addColumn('raw_row_count', function($unsanitize){
                return  $unsanitize->raw_row_count;
            })
            ->addColumn('raw_total_amount', function($unsanitize){
                return  $unsanitize->raw_total_amount;
            })
            ->addColumn('sanitized_by', function($unsanitize){
                return $unsanitize->sanitized_by;
            })
            ->addColumn('date_sanitized', function($unsanitize){
                return date('M d, Y', strtotime($unsanitize->date_sanitized));
            })
            ->rawColumns([
                'raw_check',
                'raw_image',
                'raw_button',
                'raw_row_count',
                'raw_total_amount',
                'raw_id',
                'raw_doctor',
                'raw_status',
                'raw_license',
                'raw_address',
                'raw_branchname',
                'raw_lbucode',
                'raw_amount',
                'sanitized_by',
                'date_sanitized'
            ])
            ->make(true);
            
    }

    public function postRealtimeSanitationData(Request $request){

        $raw_id = $request->raw_id;
        $checked = $request->checked;

        $user = Auth::user();
        $sanitation_exists = Checking::where('sanitation_id', $raw_id)->first();

        $selected_exists = Checking::where('sanitation_id', $raw_id)->where('user_id', '!=', $user->auth_id)->first();

        if($selected_exists){

            return response()->json([
                'status' => true,
                'dm_name' => $selected_exists->user->auth_fullname,
                'checked' => 'exists'
            ], 200);
        }

        if(Checking::where('sanitation_id', $raw_id)->where('user_id', $user->auth_id)->exists()){

            $sanitation_exists->delete();

           	$data = [
           		'status' => true,
            	'user_id' => $user->auth_id,
            	'raw_id' => $raw_id,
            	'checked' => 'unchecked'
            ];

            broadcast(new RealtimeSanitationEvent($data))->toOthers();

            return response()->json([
                'status' => true,
            ], 200);
        }

        if(!$sanitation_exists){

            $check = new Checking;
            $check->sanitation_id = $raw_id;
            $check->user_id = $user->auth_id;
            $check->save();

            $data = [
           		'status' => true,
                'checked' => 'checked',
                'user_id' => $user->auth_id,
                'raw_id' => $raw_id,
                'color' => $user->tag_color,
                'avatar' => Avatar::create($user->auth_fullname)
                                ->setBackground($this->colourBrightness($user->tag_color, -0.3))
                                ->setDimension(20, 20)
                                ->setfontSize(10)
                                ->toSvg()

            ];

            broadcast(new RealtimeSanitationEvent($data))->toOthers();

            return response()->json([
                'status' => true,
            ], 200);

        }


    }

    public function postRealtimeCheckAllRows(Request $request){

        $user = Auth::user();

        if($request->checked == 'true'){
            
            $array_ids = explode(",", $request->raw_ids);

            for($i = 0; $i <= array_key_last($array_ids); $i++){
                
                $check = new Checking;
                $check->sanitation_id = $array_ids[$i];
                $check->user_id = $user->auth_id;
                $check->save();
            }
            
        }else{

            $array_ids = explode(",", $request->raw_ids);

            Checking::whereIn('sanitation_id', $array_ids)->delete();
        }

        $data = [
                'status' => true,
                'user_id' => $user->auth_id,
                'name' => $user->auth_fullname,
                'raw_ids' => $array_ids,
                'checked' => 'checkall',
                'checkrows' => $request->checked,
                'color' => $user->tag_color,
                'avatar' => Avatar::create($user->auth_fullname)
                                ->setBackground($this->colourBrightness($user->tag_color, -0.5))
                                ->setDimension(20, 20)
                                ->setfontSize(10)
                                ->toSvg()

        ];
        
        broadcast(new RealtimeSanitationEvent($data))->toOthers();
        
        return response()->json([
            'status' => true
        ], 200);
    }

    public function postSetRuleSanitize(Request $request){

        $pluck_ids = explode(",", $request->raw_ids);

        $render = [];

        $toSanitizes = Sanitize::select('raw_id',
                        'raw_doctor',
                        'raw_license',
                        'raw_address',
                        'raw_branchname',
	                    'raw_lbucode')
                    ->whereIn('raw_id', $pluck_ids)->get();

        $doctors = Doctor::where('sanit_group', '!=', 'UNIDENTIFIED')->orderBy('sanit_id', 'ASC')->get();

        $html = view('widgets.rule_sanitation', compact('toSanitizes', 'doctors'))
            ->render();

        $render[] = $html;


        return response()->json([
            'responseHtml' => $render
        ], 200);
    }

    public function postSetRuleSanitizeOne(Request $request){

        $render = [];

        $toSanitizes = Sanitize::select('raw_id',
                        'raw_doctor',
                        'raw_license',
                        'raw_address',
                        'raw_branchname',
	                    'raw_lbucode')
                    ->where('raw_id', $request->raw_id)->get();

        $doctors = Doctor::where('sanit_group', '!=', 'UNIDENTIFIED')->orderBy('sanit_id', 'ASC')->get();

        $html = view('widgets.rule_sanitation', compact('toSanitizes', 'doctors'))
            ->render();

        $render[] = $html;


        return response()->json([
            'responseHtml' => $render
        ], 200);
    }

    public function postRuleSanitation(Request $request){

       
        $dataArr = [];

        array_push($dataArr, array(
                            'column' => 'raw_mdcode',
                            'value' => $request->mdCode)
                        );

        if($request->filled('rawDoctor'))
        {
            array_push($dataArr,array(
                            'column' => 'raw_doctor',
                            'value' => $request->rawDoctor
                        ));
        }

        if($request->filled('rawLicense'))
        {
            array_push($dataArr,array(
                            'column' => 'raw_license',
                            'value' => $request->rawLicense
                        ));
        }

        if($request->filled('rule_location'))
        {
            array_push($dataArr,array(
                            'column' => 'raw_address',
                            'value' => $request->rule_location
                        ));
        }

        if($request->filled('rule_branch_name'))
        {
            array_push($dataArr,array(
                            'column' => 'raw_branchname',
                            'value' => $request->rule_branch_name
                        ));
        }

        if($request->filled('rule_lba_code'))
        {
            array_push($dataArr,array(
                            'column' => 'raw_lbucode',
                            'value' => $request->rule_lba_code
                        ));
        }

        $addedRules = $this->rules->add($dataArr);
        
        $resp = [
            'raw_id' => explode(',', $request->rawId),
            'mdCode' => $request->mdCode,
            'rules' => $addedRules
        ];

        return response()->json($resp);

    }

    public function postMarkAllUnidentified(Request $request){

        $user = Auth::user();

        $raw_ids = explode(",", $request->raw_ids);

        $unsanitize = Sanitize::whereIn('raw_id', $raw_ids)->get();

        foreach($unsanitize as $key => $sanitize){

            $update = Sanitize::where('raw_doctor', $sanitize['raw_doctor'])
                        ->where('raw_license', $sanitize['raw_license'])
                        ->where('raw_branchcode', $sanitize['raw_branchcode'])
                        ->where('raw_address', $sanitize['raw_address'])
                        ->update([
                            'raw_corrected_name' => $sanitize['raw_doctor'],
                            'raw_status' => 'Unidentified',
                            'sanitized_by' => $user->auth_fullname
                        ]);

            
        }

        Checking::whereIn('sanitation_id', $raw_ids)->delete();

        $doneToUnidentified = Sanitize::whereIn('raw_id', $raw_ids)->get();

        $sanitizeRow = Sanitize::where('raw_status', '!=', '')->count();
        $unsanitizeRow = Sanitize::where('raw_status', '=', '')->count();

        $data = [
                'status' => true,
                'user_id' => $user->auth_id,
                'checked' => 'MarkUnidentified',
                'sanitizeRow' => $sanitizeRow,
                'unsanitizeRow' => $unsanitizeRow,
                'doneToUnidentified' => $doneToUnidentified

        ];
        
        broadcast(new RealtimeSanitationEvent($data))->toOthers();


        return response()->json([
            'status' => true
        ], 200);

    }

    public function colourBrightness($hex, $percent){
        // Work out if hash given
        $hash = '';
        if (stristr($hex, '#')) {
            $hex = str_replace('#', '', $hex);
            $hash = '#';
        }
        /// HEX TO RGB
        $rgb = [hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2))];
        //// CALCULATE
        for ($i = 0; $i < 3; $i++) {
            // See if brighter or darker
            if ($percent > 0) {
                // Lighter
                $rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1 - $percent));
            } else {
                // Darker
                $positivePercent = $percent - ($percent * 2);
                $rgb[$i] = round($rgb[$i] * (1 - $positivePercent)); // round($rgb[$i] * (1-$positivePercent));
            }
            // In case rounding up causes us to go to 256
            if ($rgb[$i] > 255) {
                $rgb[$i] = 255;
            }
        }
        //// RBG to Hex
        $hex = '';
        for ($i = 0; $i < 3; $i++) {
            // Convert the decimal digit to hex
            $hexDigit = dechex($rgb[$i]);
            // Add a leading zero if necessary
            if (strlen($hexDigit) == 1) {
                $hexDigit = "0" . $hexDigit;
            }
            // Append to the hex string
            $hex .= $hexDigit;
        }
        return $hash . $hex;
    }


    public function rulesToBeCreated(Request $request)
    {
     
        $dataArr = [];

        array_push($dataArr, array(
                            'column' => 'raw_mdcode',
                            'value' => $request->mdCode)
                        );

        if($request->filled('rawDoctor'))
        {
            array_push($dataArr,array(
                            'column' => 'raw_doctor',
                            'value' => $request->rawDoctor
                        ));
        }

        if($request->filled('rawLicense'))
        {
            array_push($dataArr,array(
                            'column' => 'raw_license',
                            'value' => $request->rawLicense
                        ));
        }

        if($request->filled('rule_location'))
        {
            array_push($dataArr,array(
                            'column' => 'raw_address',
                            'value' => $request->rule_location
                        ));
        }

        if($request->filled('rule_branch_name'))
        {
            array_push($dataArr,array(
                            'column' => 'raw_branchname',
                            'value' => $request->rule_branch_name
                        ));
        }

        if($request->filled('rule_lba_code'))
        {
            array_push($dataArr,array(
                            'column' => 'raw_lbucode',
                            'value' => $request->rule_lba_code
                        ));
        }

        $addedRules = $this->rules->add($dataArr);
        
        $resp = [
            'mdCode' => $request->mdCode,
            'rules' => $addedRules
        ];

        return response()->json($resp);
    }

    public function getByMdCode($mdCode){
        $mdData = Doctor::where("sanit_mdcode", $mdCode)->first();
        return $mdData;
    }

    public function getByRulesDetails($ruleCode){
        $dataArr = [];

        $ruleId = Details::where("rule_code", $ruleCode)->get();

        foreach($ruleId as $key => $rule){
            array_push($dataArr,array(
                'column' => $rule->details_column_name,
                'operation' => $rule->details_value_optr,
                'value' => $rule->details_value,
                'condition' => $rule->details_condition_optr,
            ));

        }
        return $dataArr;
    }

    public function getByRawIds($ruleCode){
        $rulesDetails = $this->getByRulesDetails($ruleCode);
        $rules_affected = [];
        $toRemove = "         x";
        for($i = 0; $i <= array_key_last($rulesDetails); $i++){

        array_push($rules_affected,array(
            $rulesDetails[$i]['column'], 
            '=',
            trim($rulesDetails[$i]['value'], $toRemove)
        ));
       }
       /* $merged_array = call_user_func_array('array_merge', $rules_affected); */
        $getRawIds = DB::table("sanitation_result1")
        ->where($rules_affected)
        ->get(['raw_id', 'raw_doctor']);
        return $getRawIds;
    }
    
    public function updateMdByMdCode(Request $request){
        
        $user = Auth::user();
        $getIds = $this->getByRawIds($request->ruleCode);
        $catch = $this->getByMdCode($request->mdCode);
        
        // $raw_array_ids = [];
        
        // for($z=0; $z<count($getIds); $z++){
        //      $raw_array_ids = $getIds[$z]->raw_id;
        //  }
        
        // $raw_ids = explode(",", $raw_array_ids);
        // $unsanitize = Sanitize::whereIn('raw_id', $raw_ids)->get();
        
        for($i = 0; $i<count($getIds); $i++) {
             $sanitize =  DB::table('sanitation_result1')
                  ->where('raw_id', '=', $getIds[$i]->raw_id)
                  ->update([
                      'raw_status' => $catch->sanit_group,
                      'raw_corrected_name' => $catch->sanit_mdname,
                      'raw_universe' => $catch->sanit_universe,
                      'raw_mdcode' => $catch->sanit_mdcode,
                      'sanitized_by' => $user->auth_fullname,
                  ]);  
       }

       Checking::whereIn('sanitation_id', explode(',', $request->rule_raw_id))->delete();

       $doneToSanitized = Sanitize::whereIn('raw_id', explode(',', $request->rule_raw_id))->get();
       $sanitizeRow = Sanitize::where('raw_status', '!=', '')->count();
    
       $unsanitizeRow = Sanitize::where('raw_status', '=', '')->count();
       $data = [
        'status' => true,
        'user_id' => $user->auth_id,
        'checked' => 'MarkAsSanitized',
        'sanitizeRow' => $sanitizeRow,
        'unsanitizeRow' => $unsanitizeRow,
        'doneToSanitized' => $doneToSanitized
        
        ];

        broadcast(new RealtimeSanitationEvent($data))->toOthers();

        return response()->json([
            'status' => true
        ], 200);
    }

    public function updateRawDoctors(){
        $getRawDoctor = DB::table('sanitation_result1')
                            ->get(['raw_id','raw_doctor']);
       
        foreach($getRawDoctor as $key => $doctor){
                
            $id = $getRawDoctor[$key]->raw_id;
            
            if(substr($doctor->raw_doctor, 0,1) == " "){
                $trimmed_md = trim($getRawDoctor[$key]->raw_doctor, " ");
                /*  $namesToUpdate = DB::statement("UPDATE sanitation_result1 SET raw_doctor='$trimmed_md' WHERE raw_id='$id'"); */
                $namesToUpdate = DB::table('sanitation_result1')
                                    ->where('raw_id', $id)
                                    ->update(['raw_doctor' => $trimmed_md]);
            }
        }
    }

}