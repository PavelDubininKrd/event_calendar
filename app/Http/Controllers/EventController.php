<?php

namespace App\Http\Controllers;

use App\CalendarEvent;
use App\Company;
use App\Rules\ChangeDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $events = CalendarEvent::with('user')->orderBy('date')->orderBy('change')->paginate(10);
        return view('pages.show', compact('events' ));
    }

    public function index()
    {
        $events = CalendarEvent::with('user')->orderBy('date')->paginate(10);
        return view('pages.show', compact('events' ));
    }

    public function create() {
        return view('pages.event_create');
    }

    public function store(Request $request) {
        $company_save = Company::firstOrCreate(['name' => $request->company_name]);
        $user_id = Auth::id();

        $validatedData = $request->validate([
            'title' => 'required',
            'cost' => 'required|numeric',
            'type' => 'required',
            'responsible' => 'required',
            'date' => 'required|date',
            'change' => ['required', new ChangeDate($request->all())],
        ]);
        $validatedData['user_id'] = $user_id;
        $validatedData['company_id'] = $company_save->id;
        CalendarEvent::create($validatedData);

        $company = Company::find($company_save->id);
        $company->users()->syncWithoutDetaching($user_id);

        return redirect()->route('show');
    }

    public function edit($id) {
        $event = CalendarEvent::findOrFail($id);
        return view('pages.edit', compact('event'));
    }

    public function update(Request $request, $id) {
        $company_save = Company::firstOrCreate(['name' => $request->company_name]);
        $event = CalendarEvent::find($id);
        $validatedData = $request->validate([
            'title' => 'required',
            'cost' => 'required|numeric',
            'type' => 'required',
            'responsible' => 'required',
            'date' => 'required',
            'change' => [
                'required',
                Rule::unique('calendar_events')->ignore($event->id,'id')->where(function ($query) use ($event, $request) {
                    return $query->where('date', $request->date)->where('user_id', $event->user_id);
                })
        ]]);
        $validatedData['company_id'] = $company_save->id;
        $event->update($validatedData);

        return redirect()->route('show');
    }

    public function eventAndCompanyDestroy($id, $company_id) {
        CalendarEvent::where('id', $id)->delete();
        $company = Company::with('events')->where('id', $company_id)->first();
        if ($company->events->isEmpty()) {
            Company::where('id', $company_id)->delete();
        }
        // Cannot delete or update a parent row: a foreign key constraint fails.
        return redirect()->route('show');
    }

    public function companyShow($id) {
        $companies = Company::with('events')->with('users')->where('id', $id)->paginate(10);
        return view('pages.category_list', compact('companies'));
    }
}
