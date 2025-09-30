@props(['tbodyCss', 'theadCss', 'tbodyCss'])
<div>


    <div class="custom-table-responsive {{ $tableWrapperCss ?? '' }}">
        <table class="{{ $tableCss ?? 'custom-table' }}">
            <thead class="{{ $theadCss ?? 'table-head' }}">
                <tr class="{{ $rowHeadingCss ?? '' }}">
                    @forelse($columns as $col)
                        <th>{{ $col['label'] }}</th>
                    @empty
                        {{-- Fallback: infer headers from first row --}}
                        @if(!empty($rows))
                            @foreach(array_keys((array) $rows[0]) as $key)
                                <th>{{ ucfirst(str_replace('_', ' ', $key)) }}</th>
                            @endforeach
                        @endif
                    @endforelse
                </tr>
            </thead>

            <tbody class="{{ $tbodyCss ?? 'table-body'}}">
                @foreach($rows as $rowKey => $row)
                    <tr>

                        @foreach($columns as $col)
                            @php
                                $key = $col['key'];
                                $editable = false;
                                $value = data_get($row, $key);
                                $wireModel = "rows.$rowKey.$key";
                            @endphp

                            <td>
                                @if($editable)
                                    <div x-data="{ edit: false }" class="relative inline-flex items-center gap-2">
                                        <template x-if="!edit">
                                            <span class="main-value" x-on:click="edit=true">{{ $value }}</span>
                                        </template>

                                        <template x-if="edit">
                                            <input
                                                class="special-input absolute-editable-wrapper"
                                                wire:model.defer="{{ $wireModel }}"
                                                x-on:keydown.enter="$wire.saveCell({{ $rowKey }}, '{{ $key }}'); edit=false"
                                            />
                                        </template>

                                        <button type="button" x-on:click="edit = !edit" class="absolute-editable-icon">
                                            {{-- your edit/save icon(s) --}}
                                            <x-icons.edit />
                                        </button>
                                    </div>
                                @else

                                    @if ($col['callback'])
                                        <div class="{{$col['css']}}">
                                            {{$col['callback']($row)}}
                                        </div>
                                    @else
                                    {{ $value }}
                                    @endif
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

