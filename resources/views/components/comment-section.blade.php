<h3 class="text-xl font-semibold mt-5">Comments</h3>
@if($comments->isEmpty())
    <p class="text-gray-500">No comments yet.</p>
@else
    <ul class="list-inside list-none text-gray-700">
        @foreach($comments as $comment)
            <li class="border border-gray-300 p-2 mb-2">
                <p class="border border-gray-300 p-2 mb-2">{{ $comment->content }}</p>
                <div class="flex justify-between">
                    <h5 class="">By: {{ $comment->user->name }}</h5>
                    <h6>At: {{ $comment->created_at }}</h6>
                </div>
            </li>
            @can('delete comment')
                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this comment?');"
                >
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                </form>
            @endcan
        @endforeach
    </ul>
@endif