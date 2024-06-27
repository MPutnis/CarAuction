<h3 class="text-xl font-semibold mt-5">Comments</h3>
@if($comments->isEmpty())
    <p class="text-gray-500">No comments yet.</p>
@else
    <ul class="list-disc list-inside text-gray-700">
        @foreach($comments as $comment)
            <li>
                <p>{{ $comment->content }}</p>
                <h5>By: {{ $comment->user->name }}</h5>
                <h6>At: {{ $comment->created_at }}</h6>
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