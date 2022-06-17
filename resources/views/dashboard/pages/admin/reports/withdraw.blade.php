@extends('dashboard.pages.admin.reports.layout')
@section('reportsContent')
    <table class="table table-striped">
        <thead>
        <tr>
            <td>Номер заявки</td>
            <td>Дата</td>
            <td>Номер транзакции</td>
            <td>Сумма</td>
            <td>Кошелек</td>
            <td>Назначение</td>
            <td>Комментарий</td>
        </tr>
        </thead>
        <tbody>
        @php
            $orders = $system->getTransactions('withdraw')->whereNotIn('wallet_id', [1, 2])->orderBy('id', 'DESC')->paginate(15);
        @endphp
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
                    {{ floatval($order->getAmountFloatAttribute()) }}
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
                <td>
                    {{ $order->meta['comment'] ?? '' }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="mt-5 mb-3">
        {{ $orders->links('pagination::bootstrap-4') }}
    </div>
@endsection
