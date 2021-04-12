<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WinningNumber;
use App\Models\Member;
use App\Http\Requests\DrawValidation;
use App\Rules\AddValidationRule;

class DrawController extends Controller
{
	public function index(){
		$members = Member::all();
		return view('welcome', compact(['members']));
	}	

	public function onLoad(){
		$member = Member::where('won_prize', true)->get();

		return response()->json($member);
	}

    public function draw(DrawValidation $request){
    	if($request->prizeType == 'first prize' && $request->generateRandomly == 'yes'){
    		$filterMembers = Member::where('won_prize', 0)->get();
    		$num = 0;
    		$holderWn = [];
    		$holderId = [];
    		foreach($filterMembers as $member){
    			$count = $member->winningNumbers->count();
    			if($count > $num){
    				$num = $count;
    				array_splice($holderWn, 0, count($holderWn));
    				array_splice($holderId, 0, count($holderId));
    				array_push($holderWn, $count);
    				array_push($holderId, $member->id);
    			} elseif($count == $num){
    				array_push($holderWn, $count);
    				array_push($holderId, $member->id);
    			}
    		}
    		$winningNumber = WinningNumber::inRandomOrder()->whereIn('member_id', $holderId)->get()->first();
    	} else {
	    	$winningNumberRandom = WinningNumber::inRandomOrder()->get();
	    	$winningNumber = $winningNumberRandom->reject(function ($query){
	    		return $query->member->won_prize == 1;
	    	})->map(function ($query){
	    		return $query;
	    	})->first();
    	}
    	$winningNumber->member->update(
    		[
    			'prize_type' => $request->prizeType,
    			'won_prize' => true,
    		]
    	);
    	return response()->json($winningNumber);
    }

    public function loadData(Member $data){
    	return response()->json($data);
    }

    public function loadDataAdd(Member $data){
    	$count = $data->winningNumbers;
    	return response()->json($count);
    }

    public function addLuckyNumber(Request $request){
    	$validated = $request->validate(
    		[
    			'member_id' => ['required', 'numeric', new AddValidationRule],
    			'winning_number' => 'required|digits_between:1,4|numeric|unique:winning_numbers,winning_number|min:0',

    		]
    	);
    	$data = WinningNumber::create($validated);
    	return response()->json($data);
    }

    public function addNewUser(Request $request){
    	$validated = $request->validate(
    		[
    			'user' => 'required|string|unique:members,user',
    			'winning_number' => 'required|digits_between:1,4|numeric|unique:winning_numbers,winning_number|min:0',

    		]
    	);
    	$member = Member::create(
    		[
    			'user' => $request->user, 
    			'won_prize' => false,
    			'prize_type' => null,
    		]
    	);
    	$winning_number = new WinningNumber;
    	$winning_number->member_id = $member->id;
    	$winning_number->winning_number = $request->winning_number;
    	$winning_number->save();
    	return response()->json($member);
    }

    public function resetAllWinners(){
    	$members = Member::all();

    	foreach($members as $member){
    		$member->update(
    			[
    				'prize_type' => null,
    				'won_prize' => false
    			]
    		);
    	}

    	return response()->json('success');
    }
}
