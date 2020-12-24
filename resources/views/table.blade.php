@php
    /** @var \Illuminate\Support\Collection $data */
    /** @var \Illuminate\Database\Eloquent\Model $row */
    /** @var \Tovitch\BladeUI\View\Components\Table\TableColumn[] $__children */
@endphp

<div
    class="max-w-full overflow-auto overflow-y-hidden shadow rounded-lg"
    style="-webkit-overflow-scrolling: touch;"
>
    <table {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-700 dark:text-white overflow-hidden w-full rounded-lg']) }}>
        <thead class="text-gray-300 bg-gray-800 dark:bg-gray-600 text-sm font-medium text-left">
        <tr>
            @foreach($__children as $child)
                <th {{ $child->attributes->merge(['class' => ($attributes->get('narrow') ? 'py-2' : 'py-5') . ' px-2 font-semibold whitespace-no-wrap'])->except('wire:click') }}>
                    @if($sort = $child->attributes->get('sortable'))
                        <button class="flex items-center font-bold" wire:click="{{ $child->attributes->get('wire:click') }}">
                            <span class="mr-1">{{ $child->name }}</span>
                            <span class="flex flex-col">
                                <x-blade-ui-svg
                                    name="chevron-up"
                                    width="15"
                                    height="10"
                                    data-sort="{{ $sort }}"
                                    stroke-width="{{ $sort === 'asc' ? '5' : '3' }}"
                                    class="{{ $sort === 'asc' ? '' : 'text-gray-300' }}"
                                >
                                    <path d="M5 15l7-7 7 7"></path>
                                </x-blade-ui-svg>
                                <x-blade-ui-svg
                                    name="chevron-down"
                                    width="15"
                                    height="10"
                                    data-sort="{{ $sort }}"
                                    stroke-width="{{ $sort === 'desc' ? '5' : '3' }}"
                                    class="{{ $sort === 'desc' ? '' : 'text-gray-300' }}"
                                >
                                    <path d="M19 9l-7 7-7-7"></path>
                                </x-blade-ui-svg>
                            </span>
                        </button>
                    @else
                        {{ $child->name }}
                    @endif
                </th>
            @endforeach
            @isset($data[0], $data[0]['routes'])
                <th></th>
            @endisset
        </tr>
        </thead>

        @if($data instanceof \Illuminate\Pagination\AbstractPaginator && $data->hasPages())
            <tbody class="hidden" wire:loading.remove.class="hidden">
            @foreach(range(1, $data->perPage()) as $index)
                <tr {{ $resolveRowStyle($loop, $data[0]) }}>
                    @foreach($__children as $child)
                        <td
                            {{ $resolveDataStyle($loop, $data[0], $child) }}
                            {{ $child->alignment() }}
                        >
                        <span class="rounded text-transparent bg-gray-300 dark:bg-gray-600"
                        >{{ str_repeat('_', rand(15, 20)) }}</span>
                        </td>
                    @endforeach
                    @isset($data[0]['routes'])
                        <td
                            {{ $resolveDataStyle($loop, $data[0], $child) }}
                            {{ $child->alignment() }}
                            width="40"
                        >
                            <x-blade-ui-svg class="text-gray-600" name="dots-horizontal" />
                        </td>
                    @endisset
                </tr>
            @endforeach
            </tbody>
        @endif

        <tbody wire:loading.remove>
        @forelse($data as $row)
            <tr {{ $resolveRowStyle($loop, $row) }}>
                @foreach($__children as $child)
                    <td
                        {{ $resolveDataStyle($loop, $row, $child) }}
                        {{ $child->alignment() }}
                    >
                        @if($child->isDate())
                            <span title="{{ $row[$child->attribute] }}">
                                {{ \Carbon\Carbon::parse($row[$child->attribute])->format($child->date) }}
                            </span>
                        @elseif($child->isBoolean())
                            <span title="{{ (bool) $row[$child->attribute] ? 'Actif' : 'Inactif' }}">
                                <svg
                                    class="w-4 h-4 {{ (bool) $row[$child->attribute] ? 'text-green-500' : 'text-red-500' }}"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <circle r="10" cx="12" cy="12"></circle>
                                </svg>
                            </span>
                        @elseif(! is_null($child->component))
                            {!! $child->renderComponentView($row) !!}
                        @else
                            {{ $row[$child->attribute] ?? $child->attributes->get('empty-message') }}
                        @endif
                    </td>
                @endforeach

                @isset($row['routes'])
                    <td {{ $resolveDataStyle(new \stdClass, $row, $child) }} width="40">
                        <div class="relative" x-data="{ show: false }">
                            <button
                                class="text-gray-600 flex items-center p-1 border border-transparent rounded-r duration-75 border-gray-400 bg-white"
                                style="transition-property: border, background-color"
                                x-on:mouseenter="show = true"
                                x-on:mouseleave="show = false"
                                :class="{ 'border-gray-400 bg-white': show, 'rounded-l': ! show }"
                            >
                                <x-blade-ui-svg name="dots-horizontal" />
                            </button>

                            <div
                                class="absolute top-0 bg-white rounded-l"
                                style="right: 100%"
                                x-on:mouseenter="show = true"
                                x-on:mouseleave="show = false"
                                x-show.transition.opacity.75ms="show"
                            >
                                <div class="flex items-center">
                                    @foreach($row['routes'] as $name => $route)
                                        @switch($name)
                                            @case('edit')
                                            <a
                                                class="p-1 border-t border-b border-l border-gray-400 {{ $loop->first ? 'rounded-l' : '' }}"
                                                href="{{ $route }}"
                                                data-tippy-content="Éditer"
                                            >
                                                <x-blade-ui-svg class="text-gray-600 hover:text-gray-900" name="pencil-alt" />
                                            </a>
                                            @break
                                            @case('show')
                                            <a
                                                class="p-1 border-t border-b border-l border-gray-400 {{ $loop->first ? 'rounded-l' : '' }}"
                                                href="{{ $route }}"
                                                data-tippy-content="Voir"
                                            >
                                                <x-blade-ui-svg class="text-gray-600 hover:text-gray-900" name="eye" />
                                            </a>
                                            @break
                                            @case('delete')
                                            <form
                                                class="inline-flex"
                                                action="{{ $route }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    class="p-1 border-t border-b border-l border-gray-400 {{ $loop->first ? 'rounded-l' : '' }}"
                                                    data-tippy-content="Supprimer"
                                                >
                                                    <x-blade-ui-svg class="text-red-400 hover:text-red-600" name="trash" />
                                                </button>
                                            </form>
                                            @break
                                        @endswitch
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </td>
                @endisset
            </tr>
        @empty
            <tr>
                <td class="p-10 text-gray-600 dark:text-gray-400" colspan="{{ count($__children) + (isset($row['routes']) ? 1 : 0) }}">
                    <div class="flex flex-col items-center justify-between">
                        <x-blade-ui-svg class="mb-2" name="database" width="60" height="60" stroke-width="1" />
                        {{ $emptyMessage }}
                    </div>
                </td>
            </tr>
        @endforelse
        </tbody>

        @if($data instanceof \Illuminate\Pagination\AbstractPaginator && $data->hasPages())
            <tfoot class="border-t">
            <tr>
                <td class="p-2" colspan="{{ count($__children) + (isset($row['routes']) ? 1 : 0) }}">
                    {{ $data->links(\Tovitch\BladeUI\BladeUI::$paginationView) }}
                </td>
            </tr>
            </tfoot>
        @endif
    </table>
</div>
