<?php

namespace App\Http\Controllers;

// use App\Events\PushResult;
use App\Http\Requests\ResultPostRequest;
use App\Models\Party;
use App\Models\Result;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ResultController extends Controller
{
    public function index(){
        $data = Party::all();
        return Inertia::render('Post',[
            'partyData' => $data
        ]);
    }

    public function store(ResultPostRequest $request)
    {
        // $checkResult = Result::where('user_id', auth()->user()->id)
        $checkResult = Result::where('user_id', $request->user_id)
            ->where('party_id', $request->party_id)
            ->where('lga_id', $request->lga_id)
            ->where('ward_id', $request->ward_id)
            ->where('pu_id', $request->pu_id)
            ->get()
            ->toArray();

        if (count($checkResult) !== 0) {
            return redirect()
                ->back()
                ->with('message', [
                    'type' => 'error',
                    'text' =>'Result was posted already! '
                ]);
        }

        $data = [
            // 'user_id' => auth()->user()->id,
            'user_id' => $request->user_id,
            'party_id' => $request->party_id,
            'lga_id' => $request->lga_id,
            'ward_id' => $request->ward_id,
            'pu_id' => $request->pu_id,
            'vote_count' => $request->vote_count,
        ];

        try {
            if ($request->validated()) {
                Result::create($data);
                // PushResult::dispatch($data);
                return redirect()
                    ->back()
                    ->with('message', [
                        'type' => 'success',
                        'text' =>'Result was posted successful! '
                    ]);
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('message', [
                    'type' => 'error',
                    'text' => 'Something went wrong.',
                ]);
        }
    }
    public function getResult(){
       return Result::with('party')->select([DB::raw("party_id"), DB::raw("SUM(vote_count) as votes")])
                ->groupBy('party_id')
                ->get()
                ->toArray();
    }
    public function testParty(){
        return Party::all();
    }
}