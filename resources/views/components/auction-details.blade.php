@if($car)
    <h2 class="text-2xl font-semibold">Car: {{ $car->make }} {{ $car->model }}</h2>
    <h3 class="text-xl font-semibold">Highest Bid: {{$car->auction->bids->max('amount') ? $car->auction->bids->max('amount') : 0 }}</h3>
    @else
    <h2 class="text-2xl font-semibold">Car: Not Available</h2>
@endif
<p class="text-gray-700">Auction ID: {{ $auctionId }}</p>
<p class="text-gray-700">Seller: {{ $sellerName }}</p>
<p class="text-gray-700">Mileage: {{ $car->mileage }}</p>
<p class="text-gray-700">Year: {{ $car->year }}</p>
<p class="text-gray-700">Reserve Price: {{ $car->reserve_price }}</p>
<p class="text-gray-700">Description: {{ $car->description }}</p>
<br>
<p class="text-gray-700">Auction started: {{ $startTime }}</p>
<p class="text-gray-700">Auction ends: {{ $endTime }}</p>
