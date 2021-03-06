@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-6 pl-0">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        <form method="POST" action={{ route('event.store') }}>
            @csrf
            <div class="form-group">
                <label>Имя проекта</label>
                <input type="text" class="form-control" id="projectName" name="title" value="{{ old('title') }}" required>
            </div>
            <div class="form-group">
                <label>Стоимость</label>
                <input type="number" class="form-control" id="projectName" name="cost" value="{{ old('cost') }}" required>
            </div>
            <div class="form-group">
                <label>Тип работы</label>
                <input type="text" class="form-control" id="projectName" name="type" value="{{ old('type') }}" required>
            </div>
            <div class="form-group">
                <label>Компания</label>
                <input type="text" class="form-control" id="projectName" name="company_name" value="{{ old('company_name') }}" required>
            </div>
            <div class="form-group">
                <label>Ответственный</label>
                <input type="text" class="form-control" id="projectName" name="responsible" value="{{ old('responsible') }}" required>
            </div>
            <div class="form-group">
                <label>Смена</label>
                <select class="form-control" id="projectName" name="change_id">
                    @foreach($changes as $change)
                        <option value="{{ $change->id }}">{{ $change->change_text }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Дата</label>
                <input type="date" class="form-control" id="projectName" name="date" placeholder="Дата" value="{{ old('date') }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Создать</button>
        </form>
        </div>
    </div>
@endsection
