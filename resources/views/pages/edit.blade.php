@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action={{ route('event.update', $event->id) }}>
            <input type="hidden" name="_method" value="PUT">
            @csrf
            <div class="form-group">
                <label>Имя проекта</label>
                <input type="text" class="form-control" id="projectName" name="title" value="{{ $event->title }}" required>
            </div>
            <div class="form-group">
                <label>Стоимость</label>
                <input type="text" class="form-control" id="projectName" name="cost" value="{{ $event->cost }}" required>
            </div>
            <div class="form-group">
                <label>Тип работы</label>
                <input type="text" class="form-control" id="projectName" name="type" value="{{ $event->type }}" required>
            </div>
            <div class="form-group">
                <label>Компания</label>
                <input type="text" class="form-control" id="projectName" name="company" value="{{ $event->company }}" required>
            </div>
            <div class="form-group">
                <label>Ответственный</label>
                <input type="text" class="form-control" id="projectName" name="responsible" value="{{ $event->responsible }}" required>
            </div>
            <div class="form-group">
                <label>Смена</label>
                <select class="form-control" id="projectName" name="change">
                    <option value="1" {{ $event->change == 'Утро' ? 'selected' : '' }}>Утро</option>
                    <option value="2" {{ $event->change == 'День' ? 'selected' : '' }}>День</option>
                    <option value="3" {{ $event->change == 'Ночь' ? 'selected' : '' }}>Ночь</option>
                </select>
            </div>
            <div class="form-group">
                <label>Дата</label>
                <input type="date" class="form-control" id="projectName" name="date" placeholder="Дата" value="{{ $event->date }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Изменить</button>
        </form>
    </div>
@endsection
