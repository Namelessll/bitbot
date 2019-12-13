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

                        <h5>Управление ботом</h5>
                        <div class="container_bot__settings">
                            <!-- Каптча для регистрации нового пользователя -->
                            <form action="{{route('saveSettings')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <span style="color: #6d6d6d;">Настройка каптчи для регистрации пользователей</span>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Вопрос" name="Registration_question" required value="{{$settings->Registration_question}}">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Ответ" name="Registration_answer" required value="{{$settings->Registration_answer}}">
                                    </div>
                                </div>
                                <span style="color: #6d6d6d; padding-top: 20px; display: block;">Настройка приветственного сообщения для пользователей</span>
                                <div class="row">
                                    <div class="col">
                                        <textarea class="form-control" id="validationTextarea" placeholder="Сообщение для пользователей" required rows="5" name="Welcome_message">{{$settings->Welcome_message}}</textarea>
                                    </div>
                                </div>
                                <span style="color: #6d6d6d; padding-top: 20px; display: block;">Сумма выплаты при регистрации</span>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Сумма" name="Registration_sum" required value="{{$settings->Registration_sum}}">
                                    </div>
                                </div>
                                <span style="color: #6d6d6d; padding-top: 20px; display: block;">Минимальная сумма выплаты</span>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Минимальная сумма" name="Minimal_windrow_sum" required  value="{{$settings->Minimal_windrow_sum}}">
                                    </div>
                                </div>
                                <span style="color: #6d6d6d; padding-top: 20px; display: block;">Значения для выплат</span>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Минимальное значение" name="Random_sum_start" required  value="{{$settings->Random_sum_start}}">
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Максимальное значение" name="Random_sum_end" required  value="{{$settings->Random_sum_end}}">
                                    </div>
                                </div>
                                <span style="color: #6d6d6d; padding-top: 20px; display: block;">Сумма сатоши за реферала</span>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Сумма" name="Referal_sum" required  value="{{$settings->Referal_sum}}">
                                    </div>
                                </div>
                                <span style="color: #6d6d6d; padding-top: 20px; display: block;">Процент выплаты с каждого реферала, %</span>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="Процент, %" name="Referal_procent" required  value="{{$settings->Referal_procent}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <button type="submit" class="btn btn-success" style="margin-top: 20px; display:block; width: 100%;">Сохранить</button>
                                    </div>
                                </div>
                            </form>

                            <!-- Приветственная форма -->

                            <!-- Сумма за регистрацию -->
                            <!-- Минимальная сумма для вывода -->
                            <!-- Значения для выплат -->
                            <!-- Количество сатоши за реферала -->
                            <!-- Процент выплат с каждого реферала -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
