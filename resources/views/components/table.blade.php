<div class="custom-table-responsive" :class="darkmode ? 'dmode-input-bg' : ''">
    <table class="custom-table">
        <thead class="table-head">
            <tr>
                @if ($withCheckbox)
                <th><input type="checkbox" wire:model.live="selectAll"></th>
                @endif

                @forelse ($theadings as $heading)
                    @if ($heading['canView'] && $heading['screen'] == 'all')
                    <th class="{{$heading['css']}}">
                        {{-- @if ($heading['filter'])
                            <select name="" id="">
                                <option value="#">Filter</option>
                            </select>
                        @endif --}}
                        <div class="custom-align">
                            {{ $heading['label'] ?? $heading }}

                            @if (isset($heading['filter']) && $heading['filter'])
                                <form x-cloak x-data="{
                                        toggleSelect: false,
                                        showCheckBoxes() {
                                            console.log(this.toggleSelect);
                                            this.toggleSelect = !this.toggleSelect
                                        }
                                    }">


                                    <div class="custom-selection-filter as-pointer" @click.outside="toggleSelect=false">
                                        <div class="select-box" x-on:click="showCheckBoxes">
                                            <x-slim-dashboard::icons.unfold-more />
                                        </div>

                                        @if (isset($heading['filtercols']))
                                        <div x-show="toggleSelect" id="checkBoxes" class="select-checkboxes">
                                            {{-- <select wire:model="{{$heading['wireProperty']}}" id="">
                                                @foreach ($heading['filtercols'] as $key => $value)
                                                <option value="{{$value['id']}}">{{$value['name']}}</option>
                                                @endforeach
                                            </select> --}}

                                            @foreach ($heading['filtercols'] as $key => $value)
                                            <label for="{{$heading['label'].$key}}">
                                                <input type="radio" id="{{$heading['label'].$key}}" value="{{$value['id']}}"
                                                    wire:model.live="{{$heading['wireProperty']}}">
                                                {{$value['name']}}
                                            </label>
                                            @endforeach
                                            {{-- @foreach ($this->configureFilterColumns($heading['relation'], $heading['filtercols'], $heading['filterModel'], $heading['hasCustomColKeys']) as $key => $name)
                                                <label for="{{$heading['label'].$key}}">
                                                    <input type="radio" id="{{$heading['label'].$key}}" value="{{$key}}"
                                                        wire:model.live="{{$heading['wireProperty']}}">
                                                    {{$name}}
                                                </label>
                                            @endforeach --}}

                                            @if ($heading['hasButton'])
                                            <button type="button" id="applyFilter" class="as-pointer"
                                                x-on:click="$wire.applyFilter;toggleSelect=false">Apply</button>
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                </form>
                            @endif
                        </div>
                        <div class="heading-sub-label">
                            <small>{{$heading['subLabel'] ?? ''}}</small>
                        </div>
                    </th>
                    @endif
                @empty
                @endforelse

                @if ($hasActions)
                    <th>Actions</th>
                @endif
            </tr>
        </thead>

        <tbody :class="darkmode ? 'dmode-table' : 'table-body'">
            {{ $bodyRow ?? 'bodyRow' }}
        </tbody>
    </table>
</div>
