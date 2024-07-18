<div class="table-inline-stats-summary">
   <div class="inline-stats-label">
       {!! __($this->inlineTableStatistics['description'] ?? '') !!}
   </div>
   <div class="inline-stats-items">
       @forelse ($this->inlineTableStatistics as $card)
       @if (is_array($card))
            @if ($card['canView'])
            <div class="inline-stat-item {{$card['css'] ?? ''}}">
                <div class="inline-stat-item-label">{{$card['label']}}</div>
                <div class="inline-stat-item-value">{{$card['value']}}</div>
            </div>
            @endif
       @endif
       @empty

       @endforelse
   </div>
</div>
