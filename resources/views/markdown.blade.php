# {{ $block->properties['name'] }} Block

@foreach ($block->properties as $key => $value)
  @if (is_array($value))
    ## {{ ucfirst($key) }}

    ```json
    {!! json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
    ```
  @else
    **{{ ucfirst($key) }}:** {{ $value }}
  @endif
@endforeach

@if (!empty($block->annotations))
  ## Annotations

  @foreach ($block->annotations as $tag => $content)
    - **{{ ucfirst($tag) }}:** {{ $content }}
  @endforeach
@endif
