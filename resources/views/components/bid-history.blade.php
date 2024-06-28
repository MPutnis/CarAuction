<h3 class="text-xl font-semibold mt-5 mb-1">Bid History</h3>
@if($bids->isEmpty())
    <p class="text-gray-500">No bids yet.</p>
@else
    <ul class="list-none list-inside text-gray-700">
        @foreach($bids as $bid)
            <li class="border border-gray-300 p-2 mb-2">
                <b>{{ $bid->amount }}</b> by {{ $bid->user->name }} at {{ $bid->created_at }}
            </li>
        @endforeach
    </ul>
@endif