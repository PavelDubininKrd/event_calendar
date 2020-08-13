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
                <input type="text" class="form-control" id="projectName" name="title" required>
            </div>
            <div class="form-group">
                <label>Стоимость</label>
                <input type="number" class="form-control" id="projectName" name="cost" required>
            </div>
            <div class="form-group">
                <label>Тип работы</label>
                <input type="text" class="form-control" id="projectName" name="type" required>
            </div>
            <div class="form-group">
                <label>Компания</label>
                <input type="text" class="form-control" id="projectName" name="company" required>
            </div>
            <div class="form-group">
                <label>Ответственный</label>
                <input type="text" class="form-control" id="projectName" name="responsible" required>
            </div>
            <div class="form-group">
                <label>Смена</label>
                <select class="form-control" id="projectName" name="change">
                    <option value="1">Утро</option>
                    <option value="2">День</option>
                    <option value="3">Ночь</option>
                </select>
            </div>
            <div class="form-group">
                <label>Дата</label>
                <input type="date" class="form-control" id="projectName" name="date" placeholder="Дата" required>
            </div>
            <button type="submit" class="btn btn-primary">Создать</button>
        </form>
        </div>
    </div>
@endsection
