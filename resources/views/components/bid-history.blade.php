<h3 class="text-xl font-semibold mt-5">Bid History</h3>
@if($bids->isEmpty())
    <p class="text-gray-500">No bids yet.</p>
@else
    <ul class="list-disc list-inside text-gray-700">
        @foreach($bids as $bid)
            <li>{{ $bid->amount }} by {{ $bid->user->name }} at {{ $bid->created_at }}</li>
        @endforeach
    </ul>
@endif