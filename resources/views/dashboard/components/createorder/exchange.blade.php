<createOrderExchange
:currencies="{{ \App\Models\Currency::with('payments')->get()}}"
_token="{{ csrf_token() }}"
:soon="true"
></createOrderExchange>
