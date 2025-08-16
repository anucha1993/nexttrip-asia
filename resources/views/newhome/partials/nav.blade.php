@php
  $landmass = \App\Models\Backend\LandmassModel::whereNull('deleted_at')->orderBy('id','asc')->get(); 
  $contact  = \App\Models\Backend\ContactModel::find(1); 
  $footer   = \App\Models\Backend\FooterModel::find(1);

  // สถานะสมาชิก
  $check_auth = App\Models\Backend\MemberModel::find(Auth::guard('Member')->id());

  // เมนู "ทัวร์ในประเทศ"
  $province = \App\Models\Backend\ProvinceModel::where(['status'=>'on','deleted_at'=>null])->orderBy('id','asc')->get();

  // เมนู "ทัวร์ตามเทศกาล"
  $calendar = \App\Models\Backend\CalendarModel::where('start_date','>=',date('Y-m-d'))
              ->where(['status'=>'on','deleted_at'=>null])->orderBy('start_date','asc')->get();

  // เมนู "แพ็คเกจทัวร์" (รวมประเทศที่มีแพ็คเกจ)
  $row = \App\Models\Backend\PackageModel::where('status','on')->get();
  $arr = [];
  foreach($row as $r){ $arr = array_merge($arr, json_decode($r->country_id,true) ?? []); }
  $arr = array_unique($arr);
  $count = \App\Models\Backend\CountryModel::whereIn('id',$arr)->whereNull('deleted_at')->where('status','on')->get();

  // ===== ชุดข้อมูลสำหรับ Live Search =====
  $data_country   = App\Models\Backend\CountryModel::where(['status'=>'on','deleted_at'=>null])->whereNotNull('country_name_th')->get();
  $data_city      = App\Models\Backend\CityModel::where(['status'=>'on','deleted_at'=>null])->whereNotNull('city_name_th')->get();
  $data_province  = App\Models\Backend\ProvinceModel::where(['status'=>'on','deleted_at'=>null])->whereNotNull('name_th')->get();
  $data_amupur    = App\Models\Backend\AmupurModel::where(['status'=>'on','deleted_at'=>null])->whereNotNull('name_th')->get();
  $country_famus  = App\Models\Backend\CountryModel::where('count_search','!=',0)->orderBy('count_search','desc')->limit(3)->get();
  $keyword_famus  = App\Models\Backend\KeywordSearchModel::orderBy('count_search','desc')->limit(10)->get();
@endphp

<script>
  // dataset สำหรับ live search
  window.country       = @json($data_country);
  window.city          = @json($data_city);
  window.province      = @json($data_province);
  window.amupur        = @json($data_amupur);
  window.country_famus = @json($country_famus);
  window.keyword_famus = @json($keyword_famus);
</script>

<!-- ================== HEADER ================== -->
<header class="w-full border-b border-slate-100">

  <!-- ===== Mobile Topbar ===== -->
  <div class="md:hidden bg-white">
    <div class="mx-auto max-w-[1200px] px-3 py-2 grid grid-cols-3 items-center">
      <!-- เมนู (ซ้าย) -->
      <button id="mobileMenuBtn" type="button" aria-label="Open menu"
              class="justify-self-start inline-flex h-9 w-9 items-center justify-center rounded-md">
        <svg viewBox="0 0 24 24" class="h-6 w-6 text-slate-800">
          <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </button>

      <!-- โลโก้ (กลาง) -->
      <a href="{{ url('/') }}" class="justify-self-center">
        <img src="https://nexttrip.b-cdn.net/frontend/images/logo.svg" alt="Next Trip Holiday" class="h-8 w-auto"/>
      </a>

      <!-- ไอคอน (ขวา) -->
      <div class="justify-self-end inline-flex items-center gap-3">
        <a href="{{ url('wishlist/0') }}" aria-label="Favorites" class="relative inline-flex h-8 w-8 items-center justify-center rounded-full">
          <svg viewBox="0 0 24 24" class="h-5 w-5 text-slate-500">
            <path d="M12.1 21.35l-1.1-1.02C5.14 15.24 2 12.39 2 8.96 2 6.36 4.07 4.3 6.67 4.3c1.43 0 2.8.62 3.73 1.7a5 5 0 013.73-1.7c2.6 0 4.67 2.06 4.67 4.66 0 3.43-3.14 6.28-8.9 11.37l-1.9 1.72z" fill="currentColor"/>
          </svg>
          <span id="wishCountMb" class="absolute -top-1 -right-1 inline-flex h-[16px] min-w-[16px] items-center justify-center rounded-full bg-[#f0742f] px-[5px] text-[10px] font-bold text-white">0</span>
        </a>
        <button type="button" aria-label="Search" class="inline-flex h-8 w-8 items-center justify-center rounded-full" onclick="openMobileSearch()">
          <svg viewBox="0 0 24 24" class="h-5 w-5 text-[#f0742f]">
            <path d="M11 4a7 7 0 105.29 12.29l3.7 3.7 1.42-1.42-3.7-3.7A7 7 0 0011 4zm0 2a5 5 0 110 10A5 5 0 0111 6z" fill="currentColor"/>
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Backdrop -->
  <div id="backdrop" class="fixed inset-0 z-40 bg-black/40 hidden"></div>

  <!-- Offcanvas (Mobile Menu) -->
  <aside id="mobileMenu"
    class="fixed inset-y-0 left-0 z-50 w-[88%] max-w-sm bg-white shadow-2xl
           -translate-x-full transition-transform duration-200 will-change-transform
           flex flex-col rounded-r-2xl">

    <!-- header -->
    <div class="flex items-center justify-between border-b
                pl-[max(env(safe-area-inset-left),1rem)]
                pr-[max(env(safe-area-inset-right),1rem)]
                pt-[max(env(safe-area-inset-top),0.75rem)] pb-3">
      <img src="https://nexttrip.b-cdn.net/frontend/images/logo.svg" class="h-8 w-auto" alt="Next Trip Holiday">
      <button id="closeMenu" class="h-9 w-9 inline-flex items-center justify-center" aria-label="Close">
        <svg viewBox="0 0 24 24" class="h-6 w-6 text-slate-500">
          <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </button>
    </div>

    <!-- ซ่อน marker ของ summary + ลูกศรหมุนเมื่อเปิด -->
    <style>
      summary { list-style: none; } summary::-webkit-details-marker { display: none; }
      details[open] > summary svg.rotate { transform: rotate(90deg); }
    </style>



    <!-- scroll area -->
    <nav class="flex-1 overflow-y-auto overscroll-contain px-3 py-2" style="-webkit-overflow-scrolling:touch;">

      <!-- item: หน้าหลัก -->
      <a href="{{ url('/') }}"
         class="flex items-center justify-between gap-3 rounded-xl px-3 py-3.5 border-b border-slate-100">
        <span class="inline-flex items-center gap-3">
          <svg viewBox="0 0 24 24" class="h-5 w-5 text-[#f0742f]">
            <path d="M3 10.5L12 3l9 7.5v9A1.5 1.5 0 0 1 19.5 21h-15A1.5 1.5 0 0 1 3 19.5v-9Z" fill="currentColor"/>
          </svg>
          หน้าหลัก
        </span>
      </a>

      <!-- item: ทัวร์ต่างประเทศ -->
      <details class="border-b border-slate-100">
        <summary class="flex items-center justify-between gap-3 rounded-xl px-3 py-3.5 cursor-pointer">
          <span class="inline-flex items-center gap-3">
            <svg viewBox="0 0 24 24" class="h-5 w-5 text-[#f0742f]">
              <circle cx="12" cy="12" r="9" fill="currentColor"/>
            </svg>
            ทัวร์ต่างประเทศ
          </span>
          <svg viewBox="0 0 24 24" class="rotate h-4 w-4 text-slate-400 transition-transform"><path d="M9 5l7 7-7 7" fill="currentColor"/></svg>
        </summary>
        <div class="pb-2 pt-1 pl-3 pr-1 space-y-4">
          @foreach($landmass as $land)
            @php
              $country_mb = \App\Models\Backend\CountryModel::where([
                'landmass_id'=>$land->id,'status'=>'on','deleted_at'=>null
              ])->orderBy('id','asc')->get();
            @endphp
            <div>
              <h6 class="mb-1 px-2 text-xs font-medium tracking-wide text-slate-500 uppercase">
                {{ $land->landmass_name }}
              </h6>
              <ul class="space-y-1">
                @foreach($country_mb as $co)
                  <li>
                    <a href="{{ url('oversea/'.$co->slug) }}"
                       class="flex items-center gap-2 rounded-lg px-2 py-2 hover:bg-slate-50">
                      <img src="https://nexttrip.b-cdn.net/{{ $co->img_icon }}"
                           class="h-[18px] w-[24px] object-contain rounded-sm" alt="">
                      <span>ทัวร์{{ $co->country_name_th }}</span>
                    </a>
                  </li>
                @endforeach
              </ul>
            </div>
          @endforeach
        </div>
      </details>

      <!-- item: ทัวร์ในประเทศ -->
      <details class="border-b border-slate-100">
        <summary class="flex items-center justify-between gap-3 rounded-xl px-3 py-3.5 cursor-pointer">
          <span class="inline-flex items-center gap-3">
            <svg viewBox="0 0 24 24" class="h-5 w-5 text-[#f0742f]">
              <rect x="4" y="6" width="16" height="12" rx="2" fill="currentColor"/>
            </svg>
            ทัวร์ในประเทศ
          </span>
          <svg viewBox="0 0 24 24" class="rotate h-4 w-4 text-slate-400 transition-transform"><path d="M9 5l7 7-7 7" fill="currentColor"/></svg>
        </summary>
        <ul class="pb-2 pt-1 pl-3 pr-1 space-y-1">
          @foreach($province as $pro)
            <li><a href="{{ url('inthai/'.$pro->slug) }}"
                   class="block rounded-lg px-2 py-2 hover:bg-slate-50">ทัวร์{{ $pro->name_th }}</a></li>
          @endforeach
        </ul>
      </details>

      <!-- item: ทัวร์โปรโมชั่น -->
      <a href="{{ url('promotiontour/0/0') }}"
         class="flex items-center justify-between gap-3 rounded-xl px-3 py-3.5 border-b border-slate-100">
        <span class="inline-flex items-center gap-3">
          <svg viewBox="0 0 24 24" class="h-5 w-5 text-[#f0742f]">
            <path d="M6 3h12l-2 10H8L6 3Z" fill="currentColor"/>
          </svg>
          ทัวร์โปรโมชั่น
        </span>
      </a>

      <!-- item: ทัวร์ตามเทศกาล -->
      <details class="border-b border-slate-100">
        <summary class="flex items-center justify-between gap-3 rounded-xl px-3 py-3.5 cursor-pointer">
          <span class="inline-flex items-center gap-3">
            <svg viewBox="0 0 24 24" class="h-5 w-5 text-[#f0742f]">
              <path d="M4 4h16v4H4zM4 12h16v8H4z" fill="currentColor"/>
            </svg>
            ทัวร์ตามเทศกาล
          </span>
          <svg viewBox="0 0 24 24" class="rotate h-4 w-4 text-slate-400 transition-transform"><path d="M9 5l7 7-7 7" fill="currentColor"/></svg>
        </summary>
        <ul class="pb-2 pt-1 pl-3 pr-1 space-y-1">
          @foreach($calendar as $ca)
            <li><a href="{{ url('weekend-landing/'.$ca->id) }}"
                   class="block rounded-lg px-2 py-2 hover:bg-slate-50">ทัวร์{{ $ca->holiday }}</a></li>
          @endforeach
        </ul>
      </details>

      <!-- item: แพ็คเกจทัวร์ -->
      <details class="border-b border-slate-100">
        <summary class="flex items-center justify-between gap-3 rounded-xl px-3 py-3.5 cursor-pointer">
          <span class="inline-flex items-center gap-3">
            <svg viewBox="0 0 24 24" class="h-5 w-5 text-[#f0742f]">
              <path d="M3 7h18v13H3zM7 7l5-3 5 3" fill="currentColor"/>
            </svg>
            แพ็คเกจทัวร์
          </span>
          <svg viewBox="0 0 24 24" class="rotate h-4 w-4 text-slate-400 transition-transform"><path d="M9 5l7 7-7 7" fill="currentColor"/></svg>
        </summary>
        <ul class="pb-2 pt-1 pl-3 pr-1 space-y-1">
          @foreach($count as $co)
            <li><a href="{{ url('package/'.$co->id) }}" class="block rounded-lg px-2 py-2 hover:bg-slate-50">
              แพ็คเกจ{{ $co->country_name_th }}
            </a></li>
          @endforeach
        </ul>
      </details>

      <!-- อื่น ๆ -->
      <a href="{{ url('organizetour') }}"
         class="flex items-center justify-between gap-3 rounded-xl px-3 py-3.5 border-b border-slate-100">
        <span class="inline-flex items-center gap-3">
          <svg viewBox="0 0 24 24" class="h-5 w-5 text-[#f0742f]">
            <path d="M7 12a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM4 20h16v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2Z" fill="currentColor"/>
          </svg>
          รับจัดกรุ๊ปทัวร์
        </span>
      </a>

      <a href="{{ url('aroundworld/0/0/0') }}"
         class="flex items-center justify-between gap-3 rounded-xl px-3 py-3.5 border-b border-slate-100">
        <span class="inline-flex items-center gap-3">
          <svg viewBox="0 0 24 24" class="h-5 w-5 text-[#f0742f]"><rect x="4" y="5" width="16" height="14" rx="2" fill="currentColor"/></svg>
          รอบรู้เรื่องเที่ยว
        </span>
      </a>

      <!-- Login/Register (Mobile) -->
      <a
        @if($check_auth)
          href="{{ url('/member-booking') }}"
        @else
          href="javascript:void(0)" onclick="closeMobileMenu(); openAuth('login');"
        @endif
        class="flex items-center justify-between gap-3 rounded-xl px-3 py-3.5 border-b border-slate-100">
        <span class="inline-flex items-center gap-3">
          <svg viewBox="0 0 24 24" class="h-5 w-5 text-[#f0742f]">
            <path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm-7 8a7 7 0 0 1 14 0Z" fill="currentColor"/>
          </svg>
          @if($check_auth) {{ $check_auth->name }} @else เข้าสู่ระบบ/สมัครสมาชิก @endif
        </span>
      </a>

      <!-- การ์ดศูนย์บริการ -->
      <div class="mt-4 rounded-2xl border border-orange-200 bg-orange-50 p-4 text-center">
        <div class="text-slate-600 text-sm flex items-center justify-center gap-2">
          <svg viewBox="0 0 24 24" class="h-5 w-5 text-[#f0742f]">
            <path d="M2.25 6.75c0 8.008 6.492 14.5 14.5 14.5h1.25a1.75 1.75 0 0 0 1.75-1.75v-2.263a1.75 1.75 0 0 0-1.148-1.642l-3.02-1.13a1.75 1.75 0 0 0-1.905.514l-.932 1.096a11.5 11.5 0 0 1-4.317-4.317l1.096-.932a1.75 1.75 0 0 0 .514-1.905l-1.13-3.02A1.75 1.75 0 0 0 6.763 3.5H4.5A1.75 1.75 0 0 0 2.75 5.25v1.5Z" fill="currentColor"/>
          </svg>
          ศูนย์บริการช่วยเหลือลูกค้า
        </div>
        <a href="tel:{{ $contact->phone_front }}" class="mt-1 block text-lg font-bold text-[#f0742f]">{{ $contact->phone_front }}</a>
        <div class="text-xs text-slate-600">เปิดให้บริการ {{ $contact->time }}</div>
        @php $lineUrl = "https://line.me/ti/p/".$contact->line_id; @endphp
        <a href="{{ $lineUrl }}" target="_blank"
           class="mt-3 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-[#06C755] px-4 py-2 text-white font-medium">
          <svg viewBox="0 0 24 24" class="h-5 w-5 fill-white"><path d="M19.8 4.2A9.7 9.7 0 0 0 12 1.5C6.65 1.5 2.3 5.32 2.3 10c0 4.1 3.29 7.56 7.76 8.31.3.06.72.19.83.43.09.2.06.51.03.71l-.13.84c-.03.2-.16.79.69.43 1-.4 5.34-3.15 7.28-5.4 1.38-1.56 2.14-3.42 2.14-5.33 0-1.59-.58-3.08-1.9-4.19Z"/></svg>
          LINE {{ '@'.$contact->line_id }}
        </a>
      </div>
    </nav>
  </aside>

  <!-- ===== /Mobile ===== -->

  <!-- ===== Desktop Header (Top info bar) ===== -->
  <div class="hidden md:block">
    <div class="mx-auto max-w-[1200px] px-0">
      <div class="flex items-center py-1">
        <!-- โลโก้ซ้าย -->
        <a href="{{ url('/') }}" class="shrink-0 mr-4">
          <img src="https://nexttrip.b-cdn.net/frontend/images/logo.svg" class="h-20 w-auto" alt="Next Trip Holiday">
        </a>

        <!-- กลุ่มขวา -->
        <div class="ml-auto flex items-center divide-x divide-slate-200">
          <!-- ศูนย์บริการช่วยเหลือ -->
          <div class="px-4">
            <div class="text-right">
              <div class="text-[#ef6f2e] font-semibold text-[13px]">ศูนย์บริการช่วยเหลือ</div>
              <div class="mt-1 flex justify-end items-center gap-1 text-[20px] font-bold text-[#214e9a]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 -mt-[1px] text-[#ef6f2e]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 6.75c0 8.008 6.492 14.5 14.5 14.5h1.25a1.75 1.75 0 001.75-1.75v-2.263a1.75 1.75 0 00-1.148-1.642l-3.02-1.13a1.75 1.75 0 00-1.905.514l-.932 1.096a11.5 11.5 0 01-4.317-4.317l1.096-.932a1.75 1.75 0 00.514-1.905l-1.13-3.02A1.75 1.75 0 006.763 3.5H4.5A1.75 1.75 0 002.75 5.25v1.5z"/>
                </svg>
                {{ $contact->phone_front ?? '02-136-9144' }}
              </div>
              @if(!empty($contact))
                <div class="mt-1 text-[12px] text-slate-600">Hotline : {{ $contact->hotline }}</div>
                <div class="text-[12px] text-slate-500">เปิดให้บริการ {{ $contact->time }}</div>
              @endif
            </div>
          </div>

          <!-- LINE -->
          <div class="px-4">
            <div class="flex items-center gap-2">
              <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#00c300] text-white text-[11px] font-black">LINE</span>
              <div class="flex flex-col leading-tight">
                <span class="text-[#ef6f2e] font-semibold">เราพร้อมช่วยคุณ</span>
                <span class="text-[#214e9a] font-semibold">{{ '@'.$contact->line_id ?? '@nexttripholiday' }}</span>
              </div>
            </div>
          </div>

          <!-- Social -->
          <div class="px-4">
            <div class="flex flex-col leading-tight text-center">
              <span class="text-[12px] text-[#f0742f] font-semibold mb-1">ติดตามเราที่ช่องทาง</span>
              <nav class="flex items-center gap-2">
                <a href="{{ $contact->link_fb ?? '#' }}" class="inline-flex h-7 w-7 items-center justify-center rounded bg-[#3b5998] text-white" aria-label="Facebook">
                  <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current"><path d="M22 12.07C22 6.48 17.52 2 11.93 2S2 6.48 2 12.07c0 5 3.66 9.14 8.44 9.93v-7.02H7.9V12.1h2.54V9.8c0-2.5 1.49-3.88 3.77-3.88 1.09 0 2.23.2 2.23.2v2.45h-1.25c-1.23 0-1.61.77-1.61 1.56v1.88h2.74l-.44 2.88h-2.3V22c4.78-.79 8.44-4.93 8.44-9.93z"/></svg>
                </a>
                <a href="{{ $contact->link_ig ?? '#' }}" class="inline-flex h-7 w-7 items-center justify-center rounded bg-gradient-to-br from-[#f58529] via-[#dd2a7b] to-[#8134af] text-white" aria-label="Instagram">
                  <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current"><path d="M7 2h10a5 5 0 015 5v10a5 5 0 01-5 5H7a5 5 0 01-5-5V7a5 5 0 015-5zm0 2a3 3 0 00-3 3v10a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H7zm5 3a5 5 0 110 10 5 5 0 010-10zm0 2.2a2.8 2.8 0 100 5.6 2.8 2.8 0 000-5.6zM18.2 6.8a1 1 0 110 2 1 1 0 010-2z"/></svg>
                </a>
                <a href="{{ $contact->link_yt ?? '#' }}" class="inline-flex h-7 w-7 items-center justify-center rounded bg-[#ff0000] text-white" aria-label="YouTube">
                  <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current"><path d="M23.5 6.2a3 3 0 00-2.1-2.1C19.5 3.5 12 3.5 12 3.5s-7.5 0-9.4.6A3 3 0 00.5 6.2 31 31 0 000 12a31 31 0 00.5 5.8 3 3 0 002.1 2.1c1.9.6 9.4.6 9.4.6s7.5 0 9.4-.6a3 3 0 002.1-2.1A31 31 0 0024 12a31 31 0 00-.5-5.8z"/></svg>
                </a>
                <a href="{{ $contact->link_tiktok ?? '#' }}" class="inline-flex h-7 w-7 items-center justify-center rounded bg-black text-white" aria-label="TikTok">
                  <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current"><path d="M21 8.5a6.5 6.5 0 01-4.2-1.5v7.1a6.1 6.1 0 11-5-6v2.7a3.4 3.4 0 00-1.1-.2 3.4 3.4 0 103.4 3.4V2h2.6a6.5 6.5 0 004.3 5.2z"/></svg>
                </a>
              </nav>
            </div>
          </div>
        </div>
        <!-- /กลุ่มขวา -->
      </div>
    </div>

    {{-- ========================= MAIN NAV (Desktop) ========================= --}}
    <div class="w-full bg-[#f2f2fb]">
      <div class="mx-auto max-w-7xl px-4 md:px-6">
        <nav class="flex items-center justify-between">
          <ul class="flex items-center gap-6 text-[14px] text-slate-700">
            <li>
              <a href="{{ url('/') }}" class="inline-flex items-center gap-2 py-3 text-[#f0742f]">
                <svg viewBox="0 0 24 24" class="h-5 w-5"><path d="M3 10.5L12 3l9 7.5v9a1.5 1.5 0 01-1.5 1.5H4.5A1.5 1.5 0 013 19.5v-9z" fill="currentColor"/></svg>
              </a>
            </li>

            {{-- ทัวร์ต่างประเทศ --}}
            <li class="relative group">
              <a href="javascript:void(0)" class="inline-flex h-10 items-center hover:text-[#214e9a]">ทัวร์ต่างประเทศ</a>
              <div class="invisible opacity-0 group-hover:visible group-hover:opacity-100 transition
                          absolute left-0 top-full z-40 mt-2 w-[min(100vw,940px)]">
                <div class="rounded-xl border border-slate-200 bg-white shadow-sm p-4">
                  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 max-h-[60vh] overflow-auto">
                    @foreach($landmass as $land)
                      @php
                        $country = \App\Models\Backend\CountryModel::where([
                                    'landmass_id'=>$land->id,'status'=>'on','deleted_at'=>null
                                  ])->orderBy('id','asc')->get();
                      @endphp
                      <div class="min-w-0">
                        <h4 class="mb-2 font-semibold text-slate-800">{{ $land->landmass_name }}</h4>
                        <ul class="space-y-1">
                          @foreach($country as $co)
                            <li>
                              <a href="{{ url('oversea/'.$co->slug) }}" class="flex items-center gap-2 py-1.5 hover:text-[#214e9a]">
                                <img src="https://nexttrip.b-cdn.net/{{ $co->img_icon }}" class="h-[18px] w-[24px] object-contain rounded-sm" alt="">
                                <span>ทัวร์{{ $co->country_name_th }}</span>
                              </a>
                            </li>
                          @endforeach
                        </ul>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </li>

            {{-- ทัวร์ในประเทศ --}}
            <li class="relative group">
              <a href="javascript:void(0)" class="inline-flex h-10 items-center hover:text-[#214e9a]">ทัวร์ในประเทศ</a>
              <div class="invisible opacity-0 group-hover:visible group-hover:opacity-100 transition
                          absolute left-0 top-full z-40 mt-2 w-[min(100vw,720px)]">
                <div class="rounded-xl border border-slate-200 bg-white shadow-sm p-4">
                  <ul class="grid grid-cols-2 md:grid-cols-3 gap-x-6 gap-y-1 max-h-[60vh] overflow-auto">
                    @foreach($province as $pro)
                      <li>
                        <a href="{{ url('inthai/'.$pro->slug) }}" class="block py-1.5 hover:text-[#214e9a]">
                          ทัวร์{{ $pro->name_th }}
                        </a>
                      </li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </li>

            <li><a href="{{ url('promotiontour/0/0') }}" class="inline-flex h-10 items-center hover:text-[#214e9a]">ทัวร์โปรโมชั่น</a></li>

            {{-- ทัวร์ตามเทศกาล --}}
            <li class="relative group">
              <a href="{{ url('weekend') }}" class="inline-flex h-10 items-center hover:text-[#214e9a]">ทัวร์ตามเทศกาล</a>
              <div class="invisible opacity-0 group-hover:visible group-hover:opacity-100 transition
                          absolute left-0 top-full z-40 mt-2 w-[min(100vw,520px)]">
                <div class="rounded-xl border border-slate-200 bg-white shadow-sm p-4">
                  <h4 class="mb-2 font-semibold text-slate-800">ทัวร์ตามเทศกาล</h4>
                  <ul class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-1 max-h-[50vh] overflow-auto">
                    @foreach($calendar as $ca)
                      <li>
                        <a href="{{ url('weekend-landing/'.$ca->id) }}" class="block py-1.5 hover:text-[#214e9a]">
                          ทัวร์{{ $ca->holiday }}
                        </a>
                      </li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </li>

            {{-- แพ็คเกจทัวร์ --}}
            <li class="relative group">
              <a href="{{ url('package/0') }}" class="inline-flex h-10 items-center hover:text-[#214e9a]">แพ็คเกจทัวร์</a>
              <div class="invisible opacity-0 group-hover:visible group-hover:opacity-100 transition
                          absolute left-0 top-full z-40 mt-2 w-[min(100vw,520px)]">
                <div class="rounded-xl border border-slate-200 bg-white shadow-sm p-4">
                  <h4 class="mb-2 font-semibold text-slate-800">เที่ยวด้วยตัวเอง</h4>
                  <ul class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-1 max-h-[50vh] overflow-auto">
                    @foreach($count as $co)
                      <li>
                        <a href="{{ url('package/'.$co->id) }}" class="block py-1.5 hover:text-[#214e9a]">
                          แพ็คเกจ{{ $co->country_name_th }}
                        </a>
                      </li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </li>

            <li><a href="{{ url('organizetour') }}" class="inline-flex h-10 items-center hover:text-[#214e9a]">รับจัดกรุ๊ปทัวร์</a></li>
            <li><a href="{{ url('aroundworld/0/0/0') }}" class="inline-flex h-10 items-center hover:text-[#214e9a]">รอบรู้เรื่องเที่ยว</a></li>
          </ul>

          <!-- ขวาสุด: โปรไฟล์/ค้นหา/ถูกใจ + Login/Register -->
          <div class="flex items-center gap-4">
            @if($check_auth)
              <a href="{{ url('/member-booking') }}" class="inline-flex items-center gap-2 text-[14px] text-[#214e9a]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#f0742f]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0"/>
                </svg>
                {{ $check_auth->name }}
              </a>
            @else
              <button type="button" onclick="openAuth('login')" class="inline-flex items-center gap-2 text-[14px] text-[#214e9a]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#f0742f]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0"/>
                </svg>
                เข้าสู่ระบบ/สมัครสมาชิก
              </button>
            @endif

            <!-- Desktop Search button + popover -->
            <div class="relative hidden md:block">
              <button id="navSearchBtn" type="button"
                      class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-300"
                      aria-label="Search">
                <svg viewBox="0 0 24 24" class="h-5 w-5 text-slate-600">
                  <path d="M11 4a7 7 0 105.29 12.29l3.7 3.7 1.42-1.42-3.7-3.7A7 7 0 0011 4z" fill="currentColor"/>
                </svg>
              </button>
              <div id="navSearchPanel"
                   class="absolute right-0 mt-2 w-[min(92vw,520px)] p-3 rounded-xl border border-slate-200 bg-white shadow-xl hidden">
                <div class="relative">
                  <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg viewBox="0 0 24 24" class="h-5 w-5"><path d="M11 4a7 7 0 105.29 12.29l3.7 3.7 1.42-1.42-3.7-3.7A7 7 0 0011 4z" fill="currentColor"/></svg>
                  </span>
                  <input id="nav_search" type="text" placeholder="ประเทศ, เมือง, สถานที่ท่องเที่ยว"
                         class="h-11 w-full rounded-lg border border-slate-200 pl-10 pr-3 text-sm focus:ring-2 focus:ring-slate-300 focus:outline-none" />
                  <div id="nav_livesearch" class="absolute z-50 mt-2 w-full hidden"></div>
                  <div id="nav_famus"     class="absolute z-40 mt-2 w-full hidden"></div>
                </div>
              </div>
            </div>

            <a href="{{ $check_auth ? url('/member-booking') : 'javascript:void(0)' }}" @if(!$check_auth) onclick="openAuth('login')" @endif class="inline-flex items-center justify-center h-9 w-9 rounded-full border border-slate-300 text-slate-700">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0"/>
              </svg>
            </a>

            <a href="{{ url('wishlist/0') }}" class="relative inline-flex items-center justify-center h-9 w-9 rounded-full border border-slate-300 text-slate-700">
              <svg viewBox="0 0 24 24" class="h-5 w-5"><path d="M12.1 21.35l-1.1-1.02C5.14 15.24 2 12.39 2 8.96 2 6.36 4.07 4.3 6.67 4.3c1.43 0 2.8.62 3.73 1.7a5 5 0 013.73-1.7c2.6 0 4.67 2.06 4.67 4.66 0 3.43-3.14 6.28-8.9 11.37l-1.9 1.72z" fill="currentColor"/></svg>
              <span id="wishCountDs" class="absolute -top-1 -right-1 inline-flex h-5 min-w-[20px] items-center justify-center rounded-full bg-[#f0742f] px-1.5 text-[11px] font-bold text-white">0</span>
            </a>
          </div>
        </nav>
      </div>
    </div>
  </div>
  <!-- ===== /Desktop Header ===== -->

</header>
<!-- =============== /HEADER =============== -->


{{-- ==================== AUTH MODAL ==================== --}}
<div id="authModal" class="fixed inset-0 z-[100] hidden">
  <div class="absolute inset-0 bg-black/40" onclick="closeAuth()"></div>
  <div class="relative mx-auto mt-24 w-[min(92vw,560px)] rounded-2xl bg-white shadow-lg ring-1 ring-black/5">
    <div class="flex items-center justify-between border-b px-5 py-4">
      <h3 class="text-slate-800 font-semibold">บัญชีผู้ใช้</h3>
      <button class="h-9 w-9 inline-flex items-center justify-center rounded-md hover:bg-slate-100" onclick="closeAuth()" aria-label="Close">
        <svg viewBox="0 0 24 24" class="h-6 w-6 text-slate-600"><path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      </button>
    </div>

    <div class="px-5 pt-4">
      <div class="grid grid-cols-2 rounded-full bg-slate-100 p-1 text-sm font-semibold">
        <button id="tab-login" class="rounded-full py-2 text-center transition" onclick="switchAuthTab('login')">เข้าสู่ระบบ</button>
        <button id="tab-register" class="rounded-full py-2 text-center transition" onclick="switchAuthTab('register')">สมัครสมาชิก</button>
      </div>
    </div>

    <div class="px-5 py-5">
      {{-- LOGIN --}}
      <form id="pane-login" action="{{ url('/login') }}" method="POST" class="space-y-3">
        @csrf
        <div>
          <label class="block text-sm text-slate-700">อีเมล</label>
          <input type="email" name="email" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
        </div>
        <div>
          <label class="block text-sm text-slate-700">รหัสผ่าน</label>
          <input type="password" name="password" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
        </div>
        <div class="flex items-center justify-between pt-2">
          <a href="{{ url('/forgot-password') }}" class="text-sm text-slate-600 hover:text-slate-800">ลืมรหัสผ่าน?</a>
          <button type="submit" class="rounded-lg bg-[#f0742f] px-5 py-2 text-sm font-semibold text-white hover:bg-[#e56724]">
            เข้าสู่ระบบ
          </button>
        </div>
        <div class="pt-3">
          <div class="text-center text-xs text-slate-400">หรือเข้าสู่ระบบด้วย</div>
          <div class="mt-2 flex items-center justify-center gap-3">
            <a href="{{ url('auth/facebook') }}"><img src="{{ asset('frontend/Facebook.svg') }}" class="h-9" alt="Facebook"></a>
            <a href="{{ url('/google') }}"><img src="{{ asset('frontend/gglogin.svg') }}" class="h-9" alt="Google"></a>
          </div>
        </div>
      </form>

      {{-- REGISTER --}}
      <form id="pane-register" action="{{ url('/register') }}" method="POST" class="hidden space-y-3">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div>
            <label class="block text-sm text-slate-700">ชื่อ</label>
            <input type="text" name="name" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
          </div>
          <div>
            <label class="block text-sm text-slate-700">นามสกุล</label>
            <input type="text" name="surname" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
          </div>
        </div>
        <div>
          <label class="block text-sm text-slate-700">อีเมล</label>
          <input type="email" name="email" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
        </div>
        <div>
          <label class="block text-sm text-slate-700">เบอร์โทรศัพท์</label>
          <input type="text" name="phone" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div>
            <label class="block text-sm text-slate-700">รหัสผ่าน</label>
            <input type="password" name="password" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
          </div>
          <div>
            <label class="block text-sm text-slate-700">ยืนยันรหัสผ่าน</label>
            <input type="password" name="password_confirmation" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
          </div>
        </div>
        <label class="flex items-start gap-2 text-sm text-slate-600">
          <input type="checkbox" name="accept" required class="mt-1 h-4 w-4 rounded border-slate-300">
          ฉันยอมรับ <a href="{{ url('policy') }}" class="ml-1 text-[#f0742f] hover:underline">นโยบายความเป็นส่วนตัว</a>
        </label>
        <div class="pt-1 text-right">
          <button type="submit" class="rounded-lg bg-[#f0742f] px-5 py-2 text-sm font-semibold text-white hover:bg-[#e56724]">
            สมัครสมาชิก
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- ==================== /AUTH MODAL ==================== --}}

<!-- ==================== SCRIPTS ==================== -->
<script>
  // ====== Live Search (generic) ======
  (() => {
    const el = id => document.getElementById(id);
    const norm = s => (s || '').toString().trim();
    const contains = (a, b) => norm(a).toLowerCase().includes(norm(b).toLowerCase());
    const esc = s => (s||'').toString().replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));
    const host = 'https://nexttrip.b-cdn.net/';
    const typeMap = {country:'ประเทศ', city:'เมือง', province:'จังหวัด', district:'อำเภอ/เขต', keyword:'คำค้น'};
    const escapeReg = s => (s||'').replace(/[.*+?^${}()|[\]\\]/g, '\\$&');

    function buildIndex() {
      const out = [];
      (window.country || []).forEach(c => out.push({
        type:'country', label:c.country_name_th||'', icon:c.img_icon? host+c.img_icon:'', 
        url:c.slug ? ('{{ url('oversea') }}/'+c.slug) : ('{{ url('search-tour') }}?search_data='+encodeURIComponent(c.country_name_th||'')),
        keywords:[c.country_name_th,c.country_name_en,c.code].filter(Boolean).join(' ')
      }));
      (window.city || []).forEach(ci => out.push({
        type:'city', label:ci.city_name_th||'', icon:'', url:'{{ url('search-tour') }}?search_data='+encodeURIComponent(ci.city_name_th||''), keywords:ci.city_name_th||''
      }));
      (window.province || []).forEach(p => out.push({
        type:'province', label:p.name_th||'', icon:'', url:p.slug? ('{{ url('inthai') }}/'+p.slug) : ('{{ url('search-tour') }}?search_data='+encodeURIComponent(p.name_th||'')), keywords:p.name_th||''
      }));
      (window.amupur || []).forEach(a => out.push({
        type:'district', label:a.name_th||'', icon:'', url:'{{ url('search-tour') }}?search_data='+encodeURIComponent(a.name_th||''), keywords:a.name_th||''
      }));
      (window.keyword_famus || []).forEach(k => out.push({
        type:'keyword', label:k.keyword||'', icon:'', url:'{{ url('search-tour') }}?search_data='+encodeURIComponent(k.keyword||''), keywords:k.keyword||''
      }));
      return out;
    }
    const INDEX = buildIndex();

    function makeItemHTML(it, q) {
      const label = esc(it.label).replace(new RegExp('('+escapeReg(q)+')','ig'),'<mark class="bg-yellow-200">$1</mark>');
      return `
        <li>
          <a href="${it.url}" class="flex items-center gap-2 px-3 py-2 hover:bg-slate-50 rounded-lg z">
            ${it.icon ? `<img src="${it.icon}" class="h-[16px] w-[24px] object-cover rounded-sm" alt="">` : `<span class="inline-block h-2 w-2 rounded-full bg-slate-300"></span>`}
            <span class="text-slate-800 text-sm">${label}</span>
            <span class="ml-auto text-[11px] text-slate-400">${typeMap[it.type]||''}</span>
          </a>
        </li>`;
    }
    function renderList(targetId, items, q) {
      const box = el(targetId);
      if (!box) return;
      if (!items.length) { box.classList.add('hidden'); box.innerHTML=''; return; }
      box.classList.remove('hidden');
      box.innerHTML = `
        <div class="rounded-xl border border-slate-200 bg-white shadow-lg overflow-hidden">
          <ul class="max-h-80 overflow-auto divide-y divide-slate-100">
            ${items.map(it => makeItemHTML(it, q)).join('')}
          </ul>
        </div>`;
    }
    function renderFamous(listId, fameId) {
      const target = el(fameId || listId);
      if (!target) return;
      const fameCountries = (window.country_famus || []).map(c => `
        <a href="{{ url('oversea') }}/${c.slug}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg ring-1 ring-slate-200 hover:bg-slate-50">
          <img src="${host + c.img_icon}" class="h-[16px] w-[24px] object-cover rounded-sm" alt="">
          <span class="text-sm text-slate-700">ทัวร์${esc(c.country_name_th||'')}</span>
        </a>`).join('');
      const fameKeywords = (window.keyword_famus || []).map(k => `
        <a href="{{ url('search-tour') }}?search_data=${encodeURIComponent(k.keyword||'')}"
           class="px-3 py-1.5 rounded-full bg-slate-100 text-slate-700 text-[12px] hover:bg-slate-200">${esc(k.keyword||'')}</a>`
      ).join('');
      target.classList.remove('hidden');
      target.innerHTML = `
        <div class="rounded-xl border border-slate-200 bg-white shadow-lg p-3 space-y-3">
          <div><div class="text-[13px] text-slate-500 mb-2">ประเทศยอดนิยม</div><div class="flex flex-wrap gap-2">${fameCountries || '-'}</div></div>
          <div><div class="text-[13px] text-slate-500 mb-2">คำค้นยอดฮิต</div><div class="flex flex-wrap gap-2">${fameKeywords || '-'}</div></div>
        </div>`;
    }
    function doSearch(inputId, listId, fameId) {
      const input = el(inputId); if (!input) return;
      const q = norm(input.value);
      if (!q) { renderList(listId, [], ''); renderFamous(listId, fameId); return; }
      const res = INDEX.filter(it => contains(it.label,q) || contains(it.keywords,q)).slice(0, 12);
      fameId && el(fameId)?.classList.add('hidden');
      renderList(listId, res, q);
    }
    window.attachLiveSearch = (inputId, listId, fameId) => {
      const inp = el(inputId); if (!inp) return;
      inp.setAttribute('autocomplete','off');
      inp.addEventListener('input', () => doSearch(inputId, listId, fameId));
      inp.addEventListener('focus', () => { if (!norm(inp.value)) renderFamous(listId, fameId); });
    };
    // bind both
    attachLiveSearch('nav_search','nav_livesearch','nav_famus');
    attachLiveSearch('mb_search','mb_livesearch','mb_famus');

    // click-away
    document.addEventListener('click', (e) => {
      ['navSearchPanel','nav_livesearch','mb_livesearch'].forEach(id=>{
        const box = el(id); const inputs=[el('nav_search'), el('mb_search')];
        if(box && !box.contains(e.target) && !inputs.some(n=>n && n.contains(e.target))){
          if(id!=='navSearchPanel') box.classList.add('hidden'); else box.classList.add('hidden');
        }
      });
    });
  })();

  // ====== AUTH MODAL ======
  function openAuth(which = 'login') {
    const m = document.getElementById('authModal');
    m.classList.remove('hidden');
    switchAuthTab(which);
    document.documentElement.classList.add('overflow-hidden'); // lock scroll
  }
  function closeAuth() {
    const m = document.getElementById('authModal');
    m.classList.add('hidden');
    document.documentElement.classList.remove('overflow-hidden');
  }
  function switchAuthTab(which) {
    const tLogin = document.getElementById('tab-login');
    const tReg   = document.getElementById('tab-register');
    const pLogin = document.getElementById('pane-login');
    const pReg   = document.getElementById('pane-register');
    if (which === 'register') {
      tReg.classList.add('bg-white','shadow','text-slate-900');
      tLogin.classList.remove('bg-white','shadow','text-slate-900');
      pReg.classList.remove('hidden'); pLogin.classList.add('hidden');
    } else {
      tLogin.classList.add('bg-white','shadow','text-slate-900');
      tReg.classList.remove('bg-white','shadow','text-slate-900');
      pLogin.classList.remove('hidden'); pReg.classList.add('hidden');
    }
  }

  // ====== MOBILE MENU ======
  (function () {
    const btn = document.getElementById('mobileMenuBtn');
    const panel = document.getElementById('mobileMenu');
    const backdrop = document.getElementById('backdrop');
    const closeBtn = document.getElementById('closeMenu');

    function openMenu() {
      panel.classList.remove('-translate-x-full');
      backdrop.classList.remove('hidden');
      document.documentElement.classList.add('overflow-hidden');
    }
    function closeMenuFn() {
      panel.classList.add('-translate-x-full');
      backdrop.classList.add('hidden');
      document.documentElement.classList.remove('overflow-hidden');
    }
    window.closeMobileMenu = closeMenuFn; // ให้เมนูภายในเรียกได้

    btn?.addEventListener('click', openMenu);
    closeBtn?.addEventListener('click', closeMenuFn);
    backdrop?.addEventListener('click', closeMenuFn);

    // ปิดด้วยปุ่ม Esc และปิดโมดัลหากเปิดอยู่
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') { closeMenuFn(); closeAuth(); }
    });
  })();

  // ====== Desktop search popover toggle ======
  (function(){
    const btn   = document.getElementById('navSearchBtn');
    const panel = document.getElementById('navSearchPanel');
    const input = document.getElementById('nav_search');
    btn?.addEventListener('click', () => {
      panel.classList.toggle('hidden');
      if (!panel.classList.contains('hidden')) { input?.focus(); }
    });
    document.addEventListener('keydown', (e)=>{ if(e.key==='Escape') panel?.classList.add('hidden'); });
  })();

  // ====== Count wishlist from localStorage ======
  (function(){
    try {
      const liked = JSON.parse(localStorage.getItem('likedTours') || '[]');
      const n = Array.isArray(liked) ? liked.length : 0;
      const mb = document.getElementById('wishCountMb'); if(mb) mb.textContent = n;
      const ds = document.getElementById('wishCountDs'); if(ds) ds.textContent = n;
    } catch(e){}
  })();

  // helper: open mobile search field (focus)
  function openMobileSearch(){
    // เปิดเมนูถ้ายังไม่เปิด แล้ว focus ที่ช่อง
    const panel = document.getElementById('mobileMenu');
    const backdrop = document.getElementById('backdrop');
    if (panel.classList.contains('-translate-x-full')) {
      panel.classList.remove('-translate-x-full');
      backdrop.classList.remove('hidden');
      document.documentElement.classList.add('overflow-hidden');
      setTimeout(()=>document.getElementById('mb_search')?.focus(), 200);
    } else {
      document.getElementById('mb_search')?.focus();
    }
  }
</script>
<!-- ==================== /SCRIPTS ==================== -->
