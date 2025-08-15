@props(['title','text','author','image'=>null,'rating'=>5])
@php $stars = str_repeat('★', $rating); @endphp
<div class="group relative rounded-2xl overflow-hidden bg-white ring-1 ring-slate-200 shadow-sm hover:shadow-md transition">
    @if($image)
        <div class="relative h-56 w-full">
            <img src="{{ $image }}" alt="{{ $title }}" class="h-full w-full object-cover object-center group-hover:scale-[1.03] transition duration-500" loading="lazy" width="400" height="224" />
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/10 to-transparent"></div>
            <span class="absolute top-3 right-3 inline-flex items-center gap-1 rounded-full bg-black/60 backdrop-blur px-3 py-1 text-[11px] font-medium text-amber-300 ring-1 ring-white/10">{{$stars}}<span class="text-white/70">{{number_format($rating,1)}}</span></span>
        </div>
        <div class="p-5">
            <h3 class="font-semibold text-slate-800 mb-1 line-clamp-1">{{ $title }}</h3>
            <p class="text-sm text-slate-600 leading-relaxed line-clamp-2">{{ $text }}</p>
            <div class="mt-4 flex items-center gap-3">
                <span class="h-10 w-10 rounded-full ring-2 ring-white/60 border border-white/20 bg-orange-600 text-white text-xs font-semibold grid place-content-center shadow">{{ mb_substr($author,0,2) }}</span>
                <div class="text-xs text-slate-500">
                    <span class="font-medium text-slate-700">{{ $author }}</span>
                    <span class="block text-amber-500">{{$stars}}</span>
                </div>
            </div>
        </div>
    @else
        <div class="p-6">
            <h3 class="font-semibold text-slate-800 mb-2">{{ $title }}</h3>
            <p class="text-sm text-slate-600 leading-relaxed line-clamp-4">{{ $text }}</p>
            <div class="mt-4 flex items-center gap-3">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-orange-600 text-white text-xs font-semibold">{{ mb_substr($author,0,2) }}</span>
                <div class="text-xs text-slate-500">{{ $author }} <span class="block text-amber-500">{{$stars}}</span></div>
            </div>
        </div>
    @endif
</div>
