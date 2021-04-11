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
    	$winningNumberRandom = WinningNumber::inRandomOrder()->get();
    	$winningNumber = $winningNumberRandom->reject(function ($query){
    		return $query->member->won_prize == 1;
    	})->map(function ($query){
    		return $query;
    	})->first();

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
    			'winning_number' => 'required|unique:winning_numbers,winning_number|digits_between:1,4|numeric',
    		]
    	);

    	$data = WinningNumber::create($validated);

    	return response()->json($data);
    }
}
