<?php

namespace App\Http\Controllers;

use App\CalendarEvent;
use App\Company;
use App\Rules\ChangeDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $events = CalendarEvent::with('user')->with('dictionary')->orderBy('date')->orderBy('change')->paginate(10);
        return view('event.index', compact('events' ));
    }

    public function create() {
        $changes = DB::table('changes_dictionary')->get();
        return view('event.create', compact('changes'));
    }

    public function store(Request $request) {
            $validatedData = $request->validate([
            'title' => 'required',
            'cost' => 'required|numeric|between:1,100000000',
            'type' => 'required',
            'responsible' => 'required',
            'company_name' => 'required',
            'date' => 'required|date',
            'change' => ['required', new ChangeDate($request->all())],
        ]);
        $company_save = Company::firstOrCreate(['name' => $request->company_name]);
        $user_id = Auth::id();
        $validatedData['user_id'] = $user_id;
        $validatedData['company_id'] = $company_save->id;
        $validatedData['change_id'] = $request->change;
        CalendarEvent::create($validatedData);

        return redirect()->route('event.index');
    }

    public function edit($id) {
        $event = CalendarEvent::findOrFail($id);
        return view('event.edit', compact('event'));
    }

    public function update(Request $request, $id) {
        $company_save = Company::firstOrCreate(['name' => $request->company_name]);
        /** @var CalendarEvent $event */
        $event = CalendarEvent::find($id);
        if (!$event->isOwner()) {
            abort(403, 'Отказано в доступе');
        }
        $validatedData = $request->validate([
            'title' => 'required',
            'cost' => 'required|numeric',
            'type' => 'required',
            'responsible' => 'required',
            'company_name' => 'required',
            'date' => 'required',
            'change' => ['required', new ChangeDate($request->all(), $id)]]);
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

        return redirect()->route('event.index');
    }

    public function companyShow($id) {
        $companies = Company::with('events.user')->where('id', $id)->paginate(10);
        return view('event.company_list', compact('companies'));
    }
}
