<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;

class ListController extends Controller
{
    public function index()
    {
        $todos = Todo::all(); 
//        return $todos;
        return view('list', compact('todos'));
    }

    public function create(Request $request)
    {

        $todo = new Todo;
        $todo->todo = $request->text;
        $todo->save();
        return $todo;

//        return 'Done';
//        return $request->all();
    }

    public function delete(Request $request)
    {
        Todo::where('id', $request->id)->delete();        
        return $request->all();
    }

    public function update(Request $request)
    {
        $todo = Todo::find($request->id);
        $todo->todo = $request->value;
        $todo->save();
        return $request->all();
    }

    public function search(Request $request)
    {
        // $todo = Todo::find($request->id);
        // $todo->todo = $request->value;
        // $todo->save();

        $term  = $request->term;
        $todos = Todo::where('todo','LIKE','%'.$term.'%')->get();
//        return $todos;
        if (count($todos)==0) {
            $searchResult[] = 'No todo found';
        } else {
            foreach($todos as $key => $value) {
                $searchResult[] = $value->todo;
            }
        }

        return $searchResult;

        // return $availableTags = [
        //     "ActionScript",
        //     "AppleScript",
        //     "Asp",
        //     "BASIC",
        //     "C",
        //     "C++",
        //     "Clojure",
        //     "COBOL",
        //     "ColdFusion",
        //     "Erlang",
        //     "Fortran",
        //     "Groovy",
        //     "Haskell",
        //     "Java",
        //     "JavaScript",
        //     "Lisp",
        //     "Perl",
        //     "PHP",
        //     "Python",
        //     "Ruby",
        //     "Scala",
        //     "Scheme"
        //   ];
    }
}
