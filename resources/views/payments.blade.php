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

                        <h5>Заявки на вывод <i class="fas fa-info-circle" style="cursor: pointer; color: #4a8ad8; position: relative; top: 1px;" data-toggle="tooltip" data-placement="top" title='"Одобрить" отправит сообщение пользователю об успешной обработке заявки'></i></h5>
                        <div class="container__paymnet">
                            <ul class="list-group">
                                @foreach($payments as $payment)
                                    <li class="list-group-item">
                                        @if($payment->status == 0)
                                            <span class="badge badge-warning">Ожидает обработки</span>
                                        @elseif ($payment->status == 1)
                                            <span class="badge badge-success">Одобрен</span>
                                        @else
                                            <span class="badge badge-danger">Отклонен</span>
                                        @endif

                                        <div class="content_payment__datail">
                                            <strong>ID: {{$payment->userId}}</strong>
                                            <p><strong>BTC-Кошелёк:</strong> {{$payment->btc}}</p>
                                            <p>Сумма на вывод: <strong>{{number_format($payment->value, 8, ".", "")}}</strong> BTC</p>
                                        </div>
                                        <div class="date_payment" style="color: #a2a2a2; font-size: 13px; position: absolute; right: 15px; top: 15px;">
                                            {{$payment->created_at}}
                                        </div>
                                            @if($payment->status == 0)
                                                <div class="payment_actions">
                                                    <form action="{{route('updatePaymentList')}}" method="post" enctype="multipart/form-data" style="display: inline-block;">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$payment->id}}">
                                                        <input type="hidden" name="status" value="1">
                                                        <input type="hidden" name="userId" value="{{$payment->userId}}">
                                                        <input type="hidden" name="value" value="{{number_format($payment->value, 8, ".", "")}}">
                                                        <button type="submit" class="btn btn-success">Одобрить заявку</button>
                                                    </form>
                                                    <form action="{{route('updatePaymentList')}}" method="post" enctype="multipart/form-data" style="display: inline-block;">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$payment->id}}">
                                                        <input type="hidden" name="status" value="2">
                                                        <input type="hidden" name="userId" value="{{$payment->userId}}">
                                                        <input type="hidden" name="value" value="{{number_format($payment->value, 8, ".", "")}}">
                                                        <button type="submit" class="btn btn-danger">Отклонить заявку</button>
                                                    </form>

                                                </div>
                                            @endif

                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
