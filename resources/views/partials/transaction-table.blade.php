<table class='border-collapse table-auto w-full text-sm'>
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>User Balance</th>
            <th>Transaction Type</th>
            <th>amount</th>
            <th>fee</th>
            <th>date</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($transactions as $transaction)
            <tr>
                <th>{{ $transaction->id }}</th>
                <th>{{ $transaction->user?->name }}</th>
                <th>{{ $transaction->user?->balance }}</th>
                <th>{{ $transaction->transaction_type }}</th>
                <th>{{ $transaction->amount }}</th>
                <th>{{ $transaction->fee }}</th>
                <th>{{ $transaction->date }}</th>
            </tr>
        @empty
            <tr>
                <td class="text-center" colspan='50'>No data found</td>
            </tr>
        @endforelse
    </tbody>
</table>
