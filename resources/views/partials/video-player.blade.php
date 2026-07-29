<video class="w-100" controls autoplay poster="{{ asset($video->thumbnail) }}" style="max-height:70vh;background:#000;">
    <source src="{{ asset($video->file_path) }}" type="{{ $video->mime_type ?? 'video/mp4' }}">
    Your browser does not support the video tag.
</video>
