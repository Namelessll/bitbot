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

                        <h5>Вопросы пользователей <i class="fas fa-info-circle" style="cursor: pointer; color: #4a8ad8; position: relative; top: 1px;" data-toggle="tooltip" data-placement="top" title="После отправки формы, бот отправляет пользователю ваш ответ с тегом #техподдержка"></i></h5>
                            <ul class="list-group" style="margin-bottom: 15px;">
                                @foreach($questions as $key => $question)
                                    <li class="list-group-item" style="border-left: none; border-radius: 0; border-right: none; padding: 10px 0;">
                                        <p style="font-size: 15px; background: #e8e8e8; padding: 10px;">
                                            <b>ID пользователя: {{$question->userId}}</b><br>
                                            <small style="font-weight: bold; color: #e2243e;">{{\Carbon\Carbon::now()->diffAsCarbonInterval(\Carbon\Carbon::parse($question->created_at))->locale('ru')}} назад</small>
                                            <br>
                                            {{$question->question}}
                                        </p>
                                        <div class="form_feedback">
                                            <span style="color: #7d7d7d;">Форма ответа на вопрос пользователя:</span>
                                            <form action="{{route('answerQuestion')}}" method="post" enctype="multipart/form-data" class="form__{{$question->userId}}">
                                                <div class="mb-3">
                                                    @csrf
                                                    <input type="hidden" name="ticket" value="{{$question->id}}">
                                                    <input type="hidden" name="userId" value="{{$question->userId}}">
                                                    <textarea class="form-control" name="answerUser" placeholder="Введите ответ пользователю" required></textarea>
                                                    <button class="btn btn-primary" type="submit" style="margin-top: 20px;">Ответить на заявку</button>
                                                </div>
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            {{ $questions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
