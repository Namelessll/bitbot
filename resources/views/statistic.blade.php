@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <h5>Управление пользователями</h5>
                            <div class="table-responsive-sm">
                                <table class="table">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col"># ID</th>
                                        <th scope="col" style="text-align:center;">Username</th>
                                        <th scope="col" style="text-align:center;">Количество рефералов</th>
                                        <th scope="col" style="text-align:center;">Сумма на балансе</th>
                                        <th scope="col" style="text-align:center;">Блокировка</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $key => $user)
                                        <tr>
                                            <td>{{$user->telegramId}}</td>
                                            <td style="text-align:center;">{{$user->telegramUsername}}</td>
                                            <td style="text-align:center;">{{$user->referalCount}}</td>
                                            <td style="text-align:center;">{{$user->balance}}</td>
                                            <td style="text-align:center;">{{$user->ban}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $users->links() }}
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
