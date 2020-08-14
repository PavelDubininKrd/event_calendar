<?php

namespace App\Http\Controllers;

use App\CalendarEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $events = CalendarEvent::with('user')->orderBy('date')->get();
        return view('pages.home', compact('events'));
    }

    public function create() {
        return view('pages.event_create');
    }

    public function edit($id) {
        $event = CalendarEvent::findOrFail($id);
        return view('pages.edit', compact('event'));
    }

    public function update(Request $request, $id) {
//        $user_id = Auth::id();
        $event = CalendarEvent::find($id);
        $validatedData = $request->validate([
            'title' => 'required',
            'cost' => 'required|numeric',
            'type' => 'required',
            'company' => 'required',
            'responsible' => 'required',
            'date' => 'required',
            'change' => [
                'required',
                Rule::unique('calendar_events')->ignore($event->id,'id')->where(function ($query) use ($event, $request) {
                    return $query->where('date', $request->date)->where('user_id', $event->user_id);
                })
        ]]);
        $event->update($validatedData);
        return redirect()->route('home');
    }

    public function store(Request $request)
    {
        $user_id = Auth::id();
        $validatedData = $request->validate([
            'title' => 'required',
            'cost' => 'required|numeric',
            'type' => 'required',
            'company' => 'required',
            'responsible' => 'required',
            'date' => 'required',
            'change' => Rule::unique('calendar_events')->where(function ($query) use ($user_id, $request) {
                return $query->where('date', $request->date)->where('user_id', $user_id);
            })
        ]);
        $validatedData['user_id'] = $user_id;
        CalendarEvent::create($validatedData);

        return redirect()->route('home');
    }

    public function destroy($id) {
        CalendarEvent::where('id', $id)->delete();
        return redirect()->route('home');
    }
}
