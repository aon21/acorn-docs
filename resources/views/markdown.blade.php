## Prerequisite Courses:
#### [Beginner WordPress User](https://learn.wordpress.org/course/beginner-wordpress-user/)
#### [Intermediate WordPress User](https://learn.wordpress.org/course/intermediate-wordpress-user/)
#### [Advanced WordPress User](https://learn.wordpress.org/course/advanced-wordpress-user/)
# {{ $block->properties['name'] ?? class_basename($block) }} Block
@if (!empty($block->properties['description']))
**Description:** {{ $block->properties['description'] }}
@endif
@if (!empty($block->classAnnotations))
@foreach ($block->classAnnotations as $tag => $content)
## {{ ucfirst($tag) }}
```php
{!! $content !!}
```
@endforeach
@endif
@if (!empty($block->classMethodAnnotations))
@foreach ($block->classMethodAnnotations as $tag => $content)
## {{ ucfirst($tag) }}
```php
{!! $content !!}
```
@endforeach
@endif
@foreach ($block->properties as $key => $value)
@continue(in_array($key, ['name', 'description']))

@if (is_array($value) && !empty($value))
## {{ ucfirst($key) }}
```json
{!! json_encode($value, JSON_PRETTY_PRINT) !!}
```
@elseif (!is_array($value) && !is_null($value))
**{{ ucfirst($key) }}:** {{ $value }}
@endif
@endforeach
