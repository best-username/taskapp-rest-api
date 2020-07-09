<?php

namespace App\Http\Controllers;

use Auth;
use App\Board;
use Illuminate\Http\Request;
use App\Http\Requests\BoardCreateRequest;
use App\Http\Requests\BoardUpdateRequest;
use App\Http\Resources\BoardResource;
use App\Services\BoardService;

class BoardController extends Controller
{
    /** @api {get} {{host}}/api/boards
     * Display a listing of the resource.
     */
    public function index()
    {
        $boards = Board::with('tasks')->get();
        if($boards->isNotEmpty()) {
            return response()->json(['success' => true, 'data' => BoardResource::collection($boards)->paginate(10)]);
        } else {
            return 404;
        }
    }

    /** @api {post} {{host}}/api/board
     * Store a newly created resource in storage.
     */
    public function store(BoardCreateRequest $request)
    {
        $board = (new BoardService())->storeBoard($request);
        return response()->json(['success' => true, 'data' => new BoardResource($board)]);
    }

    /** @api {get} {{host}}/api/board/1
     * Display the specified resource.
     */
    public function show(Board $board)
    {
        return response()->json(['success' => true, 'data' => new BoardResource($board)]);
    }

    /** @api {put} {{host}}/api/board/58
     * Update the specified resource in storage.
     */
    public function update(BoardUpdateRequest $request, Board $board)
    {
        $this->authorize('update', $board);
        $board->update($request->validated());
        return response()->json(['success' => true, 'data' => new BoardResource($board)]);
    }

    /** @api {destroy} {{host}}/api/board/58
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board)
    {
        $this->authorize('delete', $board);
        $board->delete();
        return response()->json(['success' => true]);
    }
}
