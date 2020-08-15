@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-4">
                <a href="{{ route('event.create') }}"><button type="button" class="btn btn-primary">Создать новое событие</button></a>
                @foreach($companies as $company)
                    <div class="col-md-12"><h4 class="text-center">{{ $company->name }}</h4></div>
                @endforeach
            </div>
            <div class="col-md-12">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center" class="center" scope="col">Имя</th>
                        <th class="text-center" scope="col">Цена</th>
                        <th class="text-center" scope="col">Тип</th>
                        <th class="text-center" scope="col">Ответственный</th>
                        <th class="text-center" scope="col">Смена</th>
                        <th class="text-center" scope="col">Дата</th>
                        <th class="text-center" scope="col">Пользователь</th>
                        <th class="text-center" scope="col">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($companies as $company)
                        @if($company->events->isEmpty())
                            <td class="text-center" colspan="9"><h2>Нет данных. Добавьте новую компанию.</h2></td>
                        @endif
                        @foreach($company->events as $event)
                        <tr>
                            <td class="text-center">{{ $event->title }}</td>
                            <td class="text-center">{{ $event->cost }}</td>
                            <td class="text-center">{{ $event->type }}</td>

                            <td class="text-center">{{ $event->responsible }}</td>
                            <td class="text-center">{{ $event->change }}</td>
                            <td class="text-center">{{ $event->getDate() }}</td>
                            @foreach($company->users as $user)
                                <td class="text-center">{{ $user->name }}</td>
                            @endforeach
                            <td class="text-center">
{{--                                <form action="{{ route('event.destroy', $companies->id) }}" method="POST">--}}
{{--                                    @method('DELETE')--}}
{{--                                    @csrf--}}
{{--                                    <a href="{{ route('event.edit', $companies->id) }}" type="button" class="btn btn-success m-1">Изменить</a>--}}
{{--                                    <button onclick="return confirm('Вы уверены?')" type="submit" class="btn btn-danger delete">--}}
{{--                                        <input type="submit" value="Удалить" class="btn btn-danger p-0">--}}
{{--                                    </button>--}}
{{--                                </form>--}}
                            </td>
                        </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
{{--                {{ $events->links() }}--}}
            </div>
        </div>
    </div>
@endsection
