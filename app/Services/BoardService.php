<?php

namespace App\Services;

use Auth;
use App\Board;
use App\Http\Requests\BoardCreateRequest;
use Illuminate\Support\Facades\DB;

class BoardService {
    

    public function storeBoard(BoardCreateRequest $request) {
        
        DB::beginTransaction();

        try {
            $board = new Board($request->validated());
            $board->creator()->associate(Auth::user()->id);
            $board->save();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        
        DB::commit();
        return $board;
        
    }
    
}
