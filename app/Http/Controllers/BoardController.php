<?php

namespace App\Http\Controllers;

use App\Board;
use Illuminate\Http\Request;
use App\Http\Requests\BoardCreateRequest;

class BoardController extends Controller
{
    /** @api {get} {{host}}/api/boards
     * Display a listing of the resource.
     */
    public function index()
    {
        $boards = Board::all();
        if($boards) {
            return response()->json(['success' => true, 'data' => $boards]);
        } else {
            return 404;
        }
    }

    /** @api {post} {{host}}/api/board
     * Store a newly created resource in storage.
     */
    public function store(BoardCreateRequest $request)
    {
        $board = new Board($request->all());
        if($board->save()) {
            return response()->json(['success' => true, 'data' => $board]);
        } else {
            return response()->json(['success' => false, 'data' => $board]);
        }
    }

    /** @api {get} {{host}}/api/board/1
     * Display the specified resource.
     */
    public function show($id)
    {
        $board = Board::findOrFail($id);
        if($board) {
            return response()->json(['success' => true, 'data' => $board]);
        } else {
            return 404;
        }
    }

    /** @api {put} {{host}}/api/board/58
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $board = Board::findOrFail($id);
        $board->update($request->all());
        return response()->json(['success' => true, 'data' => $board]);
    }

    /** @api {destroy} {{host}}/api/board/58
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $board = Board::findOrFail($id);
        $board->delete();

        return response()->json(['success' => true]);
    }
}