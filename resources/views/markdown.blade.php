# {{ $block['name'] }} Block

**Description:** {{ $block['description'] }}

**Category:** {{ $block['category'] }}

**Icon:** {{ $block['icon'] }}

## Supports

```json
{!! json_encode($block['supports'], JSON_PRETTY_PRINT) !!}
