<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Todo;

class TodosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todo = Todo::get();
        return view('index')->with('data', $todo);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $task = $request->task;
        if(! isset($task)){
            return response([
                "success" => false
            ]);
        }
        
        $todo = new Todo;
        $todo->task = $task;
        $todo->save();
        return response([
                "success" => true,
                "id" => $todo->id
            ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        if(is_null($id) OR !is_array($id)){
             return response([
                "success" => false
            ]);
        }

        $data_id = [];

        foreach ($id as $key => $value) {
            $todo = Todo::find($value);
            if($todo)
            {
                $todo->delete();
                $data_id[] = $value;
            }
        }
        
        return response([
                "success" => true,
                "id" => $data_id,
            ]);
    }
}
