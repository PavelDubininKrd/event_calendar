<?php

namespace App\Http\Controllers;

use App\CalendarEvent;
use App\ChangeDictionary;
use App\Company;
use App\Http\Requests\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $events = CalendarEvent::with('user')->with('change')->orderBy('date')->orderBy('change_id')->paginate(10);
        return view('event.index', compact('events' ));
    }

    public function create() {
        $changes = ChangeDictionary::all();
        return view('event.create', compact('changes'));
    }

    public function store(Event $request) {
        $validatedData = $request->validated();
        $company_save = Company::firstOrCreate(['name' => $request->company_name]);
        $user_id = Auth::id();
        $validatedData['user_id'] = $user_id;
        $validatedData['company_id'] = $company_save->id;
        CalendarEvent::create($validatedData);

        return redirect()->route('event.index');
    }

    public function edit($id) {
        $event = CalendarEvent::findOrFail($id);
        return view('event.edit', compact('event'));
    }

    public function update(Event $request, $id) {
        $company_save = Company::firstOrCreate(['name' => $request->company_name]);
        /** @var CalendarEvent $event */
        $event = CalendarEvent::find($id);
        if (!$event->isOwner()) {
            abort(403, 'Отказано в доступе');
        }
        $validatedData = $request->validated();
        $validatedData['company_id'] = $company_save->id;
        $event->update($validatedData);

        return redirect()->route('event.index');
    }

    public function destroy($id) {
        $event = CalendarEvent::with('company')->where('id', $id)->first();
        if (!$event->isOwner()) {
            abort(403, 'Отказано в доступе');
        }
        $event->delete();
        if (!CalendarEvent::where('company_id', $event->company_id)->exists()) {
            $event->company->delete();
        }
        $previous_route = app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();
        if ($previous_route === 'company.show') {
            return redirect()->route('company.show', $event->company_id);
        }
        return redirect()->route('event.index');
    }

    public function companyShow($id) {
        $companies = Company::with('events.change')->with('users')->where('id', $id)->paginate(10);
        return view('event.company_list', compact('companies'));
    }
}
