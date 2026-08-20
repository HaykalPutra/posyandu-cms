{{--
    Reusable member avatar. Shows the uploaded photo if there is one,
    otherwise falls back to initials on a colored circle.

    Expected variables:
    - $member      : OrgMember
    - $sizeClass   : e.g. "w-20 h-20"
    - $bgClass     : e.g. "bg-primary-container"
    - $textClass   : e.g. "text-on-primary-container"
    - $textSize    : optional extra text-size class, e.g. "text-[14px]"
--}}
<div class="{{ $sizeClass }} rounded-full overflow-hidden {{ $bgClass }} flex items-center justify-center flex-shrink-0">
@if($member->photoSrc())
<img class="w-full h-full object-cover" src="{{ $member->photoSrc() }}" alt="{{ $member->name }}"/>
@else
<span class="{{ $textClass }} font-headline-sm font-bold {{ $textSize ?? '' }}">{{ $member->initials() }}</span>
@endif
</div>