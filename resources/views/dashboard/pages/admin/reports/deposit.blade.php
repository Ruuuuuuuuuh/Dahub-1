@extends('dashboard.pages.admin.reports.layout')
@section('reportsContent')

@php
    $orders = $system->getTransactions('deposit')->whereNotIn('wallet_id', [1, 2])->orderBy('id', 'DESC')->paginate(30);
@endphp
<div class="pb-3">
    {{ $orders->links('pagination::bootstrap-4') }}
</div>

<table class="table table-striped">
    <thead>
    <tr>
        <td>Номер заявки</td>
        <td>Дата</td>
        <td>Номер транзакции</td>
        <td>Сумма</td>
        <td>Кошелек</td>
        <td>Назначение</td>
    </tr>
    </thead>
    <tbody>
    @foreach ($orders as $order)
        <tr>
            <td>
                {{ $order->meta['order_id'] ?? '--'  }}
            </td>
            <td>
                {{ $order->created_at->Format('d.m.Y H:s') }}
            </td>
            <td>
                {{$order->uuid}}
            </td>
            <td>

                {{ floatval($order->getAmountFloatAttribute())  }}
            </td>
            <td>
                {{ $order->wallet()->first()->slug }}
            </td>
            <td>
                @if (isset($order->meta['destination']))
                    @if (is_array($order->meta['destination']))
                        @foreach ($order->meta['destination'] as $destination)
                            <span class="badge badge-success">{{$destination}}</span>
                        @endforeach
                    @else
                        <span class="badge badge-success">{{$order->meta['destination']}}</span>
                    @endif
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="mt-5 mb-3">
    {{ $orders->links('pagination::bootstrap-4') }}
</div>


@endsection
