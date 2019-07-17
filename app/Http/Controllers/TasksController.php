<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use Auth;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(5);
            
            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
        }
        
            return view('tasks.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        if (\Auth::check()) {
        $user = \Auth::user();    
        $task = new Task;
        
        $data = ['user'=>$user, 'task'=>$task];
         }
        
        return view('tasks.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        $this->validate($request, [
            'content' => 'required|max:191',
            'status' => 'required|max:10',
        ]);
        
        if (\Auth::check()) {        
        $task = new Task;
        $task->user_id= Auth::id();
        $task->content = $request->content;
        $task->status = $request->status; 
        $task->save();
        }
        
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        if (\Auth::id() === $task->user_id) {
        $user=Auth::user();
        
        $data = ['task'=>$task,  'user'=>$user ];
        }
        
        return view('tasks.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        if (\Auth::id() === $task->user_id) {
         $user=Auth::user();
         
         $data = ['task'=>$task,  'user'=>$user ];
        }
        
        return view('tasks.edit', $data);
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
        $this->validate($request, [
        'content' => 'required|max:191',
        'status' => 'required|max:10',
        ]);
        
        $task = Task::find($id);
        
        if (\Auth::id() === $task->user_id) {
        $task->content = $request->content;
        $task->status = $request->status; 
        $task->save();
        }
        
       return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        
        if (\Auth::id() === $task->user_id) {
        $task->delete();
        }
        
       return redirect('/');
    }
}
