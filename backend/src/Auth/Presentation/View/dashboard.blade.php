@extends('auth::layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Панель управления</div>

                <div class="card-body">
                    <h1>Добро пожаловать в панель управления</h1>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>Вы успешно вошли в систему.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
