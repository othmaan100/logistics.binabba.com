@props(['pdf' => false])

{{--
    Organization letterhead for printable pages and PDFs.
    Uses the uploaded letterhead image when there is one, otherwise builds one from the saved details.
    In PDFs images are embedded (dompdf can't reliably fetch URLs), and layout is a table (no flexbox in dompdf).
--}}
@php
    $o = $organization;
    $letterhead = $o?->letterhead_path ? ($pdf ? $o->embedded('letterhead_path') : $o->letterheadUrl()) : null;
    $logo = $o?->logo_path ? ($pdf ? $o->embedded('logo_path') : $o->logoUrl()) : null;
@endphp

@if ($letterhead)
    <div style="margin-bottom:14px; text-align:center">
        <img src="{{ $letterhead }}" alt="{{ $o->name }}" style="width:100%; max-height:190px; object-fit:contain">
    </div>
@elseif ($o)
    <div style="border-bottom:3px solid #17212b; margin:0 0 16px">
    <table style="width:100%; border-collapse:collapse; border:0; margin:0; font-family:Arial, Helvetica, sans-serif; color:#17212b">
        <tr>
            @if ($logo)
                <td style="width:90px; padding:0 14px 10px 0; vertical-align:middle; border:0">
                    <img src="{{ $logo }}" alt="" style="max-width:90px; max-height:70px">
                </td>
            @endif
            <td style="padding:0 0 10px; vertical-align:middle; border:0">
                <div style="font-size:22px; font-weight:bold; line-height:1.15">{{ $o->name }}</div>
                @if ($o->tagline)
                    <div style="font-size:12px; margin-top:2px">{{ $o->tagline }}</div>
                @endif
                <div style="font-size:11px; color:#4a5763; margin-top:4px">{{ $o->address }}</div>
            </td>
            <td style="padding:0 0 10px 14px; vertical-align:middle; text-align:right; font-size:11px; line-height:1.5; color:#4a5763; border:0; white-space:nowrap">
                @if ($o->rc_number)<div><strong style="color:#17212b">RC No. {{ $o->rc_number }}</strong></div>@endif
                <div>{{ implode(', ', $o->phones()) }}</div>
                <div>{{ implode(', ', $o->emails()) }}</div>
                @if ($o->website)<div>{{ $o->website }}</div>@endif
            </td>
        </tr>
    </table>
    </div>
@endif
