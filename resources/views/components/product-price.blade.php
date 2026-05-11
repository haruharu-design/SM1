@props(['product'])
@php
    $sell = $product->sellingUnitPrice();
    $list = $product->listUnitPrice();
    $pctLabel = $product->hasItemDiscount()
        ? '-'.rtrim(rtrim(number_format((float) $product->discount_percent, 2, '.', ''), '0'), '.').'%'
        : '';
@endphp
<div {{ $attributes->merge(['class' => 'text-gray-900 font-bold']) }}>
@if($product->hasItemDiscount())
    <span class="line-through text-gray-500 font-normal text-sm mr-2">Rp {{ number_format($list, 0, ',', '.') }}</span>
    <span>Rp {{ number_format($sell, 0, ',', '.') }}</span>
    <span class="inline-block ml-1 text-xs font-semibold bg-red-100 text-red-700 px-1.5 py-0.5 rounded">{{ $pctLabel }}</span>
@else
    <span>Rp {{ number_format($sell, 0, ',', '.') }}</span>
@endif
</div>
