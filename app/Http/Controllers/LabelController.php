<?php

namespace App\Http\Controllers;

use App\Label;
use Illuminate\Http\Request;
use App\Http\Requests\LabelAttachToTaskRequest;

class LabelController extends Controller
{
    /** @api {get} {{host}}/api/labels
     * Display a listing of the resource.
     */
    public function index(Label $label)
    {
        return response()->json(['success' => true, 'data' => $label->all()]);
    }

    /** @api {post} {{host}}/api/label
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $label = new Label($request->all());
        return response()->json(['success' => $label->save(), 'data' => $label]);
    }

    /** @api {get} {{host}}/api/label/1
     * Display the specified resource.
     */
    public function show(Label $label)
    {
        return response()->json(['success' => true, 'data' => $label]);
    }

    /** @api {put} {{host}}/api/label/58
     * Update the specified resource in storage.
     */
    public function update(Request $request, Label $label)
    {
        return response()->json(['success' => $label->update($request->all()), 'data' => $label]);
    }

    /** @api {destroy} {{host}}/api/label/58
     * Remove the specified resource from storage.
     */
    public function destroy(Label $label)
    {
        return response()->json(['success' => $label->delete()]);
    }
    
    /** @api {label/attach} {{host}}/api/label/attach
     * Attach the specified resource to the Board object.
     */
    public function attachToTask(LabelAttachToTaskRequest $request)
    {
        $label = Label::find($request->label_id);
        $label->tasks()->attach($request->task_id);

        return response()->json(['success' => true, 'data' => $label->tasks]);
    }
    
}
