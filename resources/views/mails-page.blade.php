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

                        <h5>Рассылка <i class="fas fa-info-circle" style="cursor: pointer; color: #4a8ad8; position: relative; top: 1px;" data-toggle="tooltip" data-placement="top" title="После отправки формы, бот рассылает всем пользователям ваше письмо с тегом #почта"></i></h5>
                            <form action="{{route('sendMailToUsers')}}" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    @csrf
                                    <textarea class="form-control" name="mail" placeholder="#почта" required></textarea>
                                    <button class="btn btn-success" type="submit" style="margin-top: 20px; width: 100%;">Отправить сообщение</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
