@foreach($newsList as $item)
    <div class="news-item mb-4">
        <h4>{{ $item->title }}</h4>
        <p><a href="{{ route('news.show', $item->id) }}">Xem chi tiết</a></p>
    </div>
@endforeach
