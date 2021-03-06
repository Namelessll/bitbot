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

                    <h5>Управление Webhook</h5>
                        <form action="{{route('setSetting')}}" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                @csrf
                                <label for="urlApi">API Сервера</label>
                                <input type="text" class="form-control" name="url" id="urlApi" aria-describedby="urlApi" placeholder="https://server.name" value="{{$settings->value}}" required>
                                <small id="emailHelp" class="form-text text-muted">Введите url вашего сервера для установки Webhook.</small>
                            </div>
                            <button type="submit" class="btn btn-success" style="margin-bottom: 20px;">Сохранить</button>
                        </form>

                        <small style="line-height: 14px !important; padding-bottom: 20px; display: block; color: #737373;">
                            Данная настройка влияет на состояние соединения API бота и сервера телеграмм.
                        </small>

                    <div class="form_container" style="display: flex;">
                        <form action="{{route('setWebhook')}}" method="post" enctype="multipart/form-data" style="margin-right: 20px;">
                            <div class="form-row">
                                @csrf
                                <button type="submit" class="btn btn-primary">Установить веб-хук</button>
                            </div>
                        </form>

                        <form action="{{route('removeWebhook')}}" method="post" enctype="multipart/form-data">
                            <div class="form-row">
                                @csrf
                                <button type="submit" class="btn btn-danger">Удалить веб-хук</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
