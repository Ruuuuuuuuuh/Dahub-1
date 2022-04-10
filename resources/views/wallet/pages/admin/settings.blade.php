
@extends('wallet.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card main-screen">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="inline-block mb-0">Настройки системы</p>
                            <div class="d-flex justify-content-end">
                                <a class="btn btn-primary" href="/dashboard/" >Вернуться назад</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>На этой странице в будущем будут храниться все настройки</p>
                        <form class="settings">
                            @csrf
                            <div class="form-group w-100 mt-4">
                                <div class="d-flex justify-content-start align-items-center">
                                    <p class="mb-0">Время выполнения заявки:</p> <input class="form-control ml-4 w-auto" name="orders_timer" type="number" min="180" step="60" value="{{$system->orders_timer}}">
                                </div>
                            </div>
                            <button class="btn btn-success" type="submit">Сохранить изменения</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){

            $('.settings').bind('submit', function(e) {
                e.preventDefault();
                let data = JSON.stringify( $(this).serializeArray() )
                $.post( "/api/system/settings/update", {
                    "_token": "{{ csrf_token() }}",
                    "data": data,
                })
                .done(function( data ) {
                    alert('Настройки успешно сохранены!')
                });
            })
        })
    </script>
@endsection
