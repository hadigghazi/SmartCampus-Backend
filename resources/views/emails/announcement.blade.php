<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
</head>
<body>
    <h1>{{ $title }}</h1>
    <h2>For: {{ $visibility }} - Announcement Category: {{ $category }}</h2>
    <p>{{ $content }}</p>

    @php
        $publishedDate = is_string($announcement->published_date) 
            ? \Carbon\Carbon::parse($announcement->published_date) 
            : $announcement->published_date;
    @endphp

    <p>Published Date: {{ $publishedDate->format('Y-m-d') }}</p>
</body>
</html>
