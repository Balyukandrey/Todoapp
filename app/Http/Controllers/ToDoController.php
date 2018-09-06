<?php

namespace App\Http\Controllers;

use App\Invitation;
use Illuminate\Http\Request;
use App\Task;
use Illuminate\Support\Facades\Auth;
use App\User;


class ToDoController extends Controller
{
    public function index(){

        if(Auth::user()->is_admin)
        {
            $coworkers = Invitation::where('admin_id', Auth::user()->id)->where('accepted', 1)->get();
            $invitations = Invitation::where('admin_id', Auth::user()->id)->where('accepted', 0)->get();
            $tasks = Task::where('user_id', Auth::user()->id)->orWhere('admin_id',  Auth::user()->id)->orderBy('created_at' , 'DESC')->paginate(4);

        }

        else
        {
            $invitations = [];
            $tasks = Task::where('user_id', Auth::user()->id)->orderBy('created_at' , 'DESC')->paginate(4);
            $coworkers = User::where('is_admin', 1)->get();

        }




        return view('index' , compact('tasks', 'coworkers', 'invitations') );

    }

    public function store(Request $request){

        if ($request->input('task')){

            $task = new Task;
            $task->content = $request->input('task');

            if(Auth::user()->is_admin)
            {
                if($request->input('assignTo') == Auth::user()->id)
                {

                    Auth::user()->tasks()->save($task);


                }
                elseif($request->input('assignTo') != null)
                {
                    $task->user_id = $request->input('assignTo');
                    $task->admin_id = Auth::user()->id;
                    $task->save();

                }
            }
            else
            {

                $invitations = Invitation::where('worker_id' , Auth::user()->id)->get();

                if(count($invitations) > 0)
                {
                    foreach($invitations as $invitation){
                        $task->user_id = $invitation->worker_id;
                        $task->admin_id = $invitation->admin_id;
                        $task->save();
                    }

                }
                    Auth::user()->tasks()->save($task);

            }


        }
        return redirect()->back();
    }

    public function edit($id){

        $task = Task::find($id);
        if(Auth::user()->is_admin)
        {
            $coworkers = Invitation::where('admin_id', Auth::user()->id)->where('accepted', 1)->get();
            $invitations = Invitation::where('admin_id', Auth::user()->id)->where('accepted', 0)->get();
        }
        else{
            $coworkers = [];
            $invitations = [];
        }
        return view('edit' , ['task'=> $task,'coworkers'=> $coworkers,'invitations'=> $invitations]);

    }

    public function update($id ,Request $request ){

        if($request->input('task')){
            $task = Task::find($id);
            $task->content = $request->input('task');
                if(Auth::user()->is_admin)
                {
                    if($request->input('assignTo') == Auth::user()->id)
                    {
                        Auth::user()->tasks()->save($task);
                    }
                    elseif($request->input('assignTo') != null)
                    {
                        $task->user_id = $request->input('assignTo');
                        $task->admin_id = Auth::user()->id;
                        $task->save();
                    }

                    else
                    {
                        Auth::user()->tasks()->save($task);

                    }
                }
                else
                {
                    $task->save();

                }
        }

        return redirect('index');
    }

    public function delete($id){

        $task = Task::find($id);
        $task->delete();
        return redirect()->back();
    }

    public function updateStatus($id){
        $task = Task::find($id);
        $task->status =! $task->status;
        $task->save();
        return redirect()->back();

    }

    public function sendInvitation(Request $request){

        if( (int) $request ->input('admin') > 0
            && !Invitation::where('worker_id', Auth::user()->id)->where('admin_id', $request ->input('admin'))->exists()
        ){
            $invitation = new Invitation();
            $invitation->worker_id = Auth::user()->id;
            $invitation->admin_id = (int) $request ->input('admin');
            $invitation->save();
        }
        return redirect()->back();
    }

    public function acceptInvitation($id){

        $invitation = Invitation::find($id);
        $invitation->accepted = true;
        $invitation->save();

        return redirect()->back();

    }

    public function denyInvitation($id){

        $invitation = Invitation::find($id);
        $invitation->delete();

        return redirect()->back();
    }

    public function deleteWorker($id){

        $invitation = Invitation::find($id);
        $invitation->delete();

        return redirect()->back();

    }
}
