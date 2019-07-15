@extends('layouts.app')

@section('content')

<h1>メッセージ一覧</h1>
    @if (Auth::id())
        @if (count($tasks) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Status</th>
                        <th>メッセージ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                    <tr>
                        <td>{!! link_to_route('tasks.show', $task->id, ['id' => $task->id]) !!}</td>
                        <td>{{ $task->status }}</td>
                        <td>{{ $task->content }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {!! link_to_route('tasks.create', '新規メッセージの投稿', null, ['class' => 'btn btn-primary']) !!}
        @endif
    @else
        @include('welcome')
    @endif
@endsection