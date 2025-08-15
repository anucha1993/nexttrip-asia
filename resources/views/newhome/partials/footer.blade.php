{{-- ========================= FOOTER (Tailwind-only, ultra-light) ========================= --}}
@php
  $contact = \App\Models\Backend\ContactModel::find(1);
  $footer  = \App\Models\Backend\FooterModel::find(1);
  $policy  = \App\Models\Backend\TermsModel::where('status','on')->orderBy('id','asc')->get();
  $landmass= \App\Models\Backend\LandmassModel::whereNull('deleted_at')->where('status','on')->orderBy('id','asc')->get();
  $lineUrl = "https://line.me/ti/p/".$contact->line_id;
@endphp

<section id="footer" class="bg-white ">
  {{-- Subscribe --}}
  <div class="bg-gradient-to-br from-orange-50 via-white to-sky-50">
    <div class="mx-auto max-w-7xl px-4 py-10">
      <div class="mx-auto max-w-4xl rounded-2xl bg-white/70 backdrop-blur-sm ring-1 ring-slate-200 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <h2 class="text-xl md:text-2xl font-bold text-slate-800">ติดตามเพื่อรับโปรโมชั่น</h2>

            <form method="post" action="{{ url('/subscribe') }}" enctype="multipart/form-data" id="subscribeForm" class="mt-4 flex rounded-lg ring-1 ring-slate-200 overflow-hidden">
              @csrf
              <div class="inline-grid place-items-center px-3 text-[#f0742f]">
                <svg viewBox="0 0 24 24" class="h-5 w-5"><path d="M2 6l10 7 10-7v12H2zM2 6l10 7L22 6H2z" fill="currentColor"/></svg>
              </div>
              <input type="email" name="email" id="email" required
                     placeholder="อีเมลของคุณ"
                     class="w-full px-3 py-2 text-sm outline-none placeholder-slate-400">
              <button type="submit"
                      class="shrink-0 bg-[#f0742f] px-4 py-2 text-white text-sm font-semibold hover:bg-[#e46725]">
                รับโปรโมชั่น
              </button>
            </form>
            <span id="error-message" class="mt-2 block text-sm text-red-600"></span>
          </div>

          {{-- QR + LINE (ซ่อนบนมือถือเพื่อความเบา) --}}
          <div class="hidden md:flex items-center justify-center gap-6">
            <img src="https://nexttripholiday.b-cdn.net/{{ $contact->qr_code }}" alt="LINE QR" class="h-28 w-28 rounded-lg ring-1 ring-slate-200 object-contain">
            <div class="text-sm">
              <a href="{{ $lineUrl }}" target="_blank" class="inline-flex items-center gap-2 rounded-full bg-[#00c300] px-4 py-2 text-white font-semibold">
                <img src="https://nexttripholiday.b-cdn.net/frontend/images/line_share.svg" class="h-5 w-5">
                {{ $contact->line_id }}
              </a>
              <div class="mt-2 text-slate-600">ติดตามเราผ่านไลน์</div>
            </div>
          </div>
        </div>
      </div>

      {{-- คำเตือนมิจฉาชีพ --}}
      <div class="mt-8 rounded-xl bg-white ring-1 ring-orange-200 p-4 text-center">
        <h3 class="font-bold text-[#b45309]">ระวัง !! กลุ่มมิจฉาชีพขายทัวร์และบริการอื่นๆ</h3>
        <p class="mt-1 text-sm text-slate-700">
          โดยแอบอ้างใช้ชื่อบริษัทเน็กซ์ ทริป ฮอลิเดย์ กรุณาชำระค่าบริการผ่านธนาคารชื่อบัญชีบริษัท
          <a href="{{ url('/') }}" class="font-semibold text-[#f0742f]">"เน็กซ์ ทริป ฮอลิเดย์ จำกัด"</a> เท่านั้น
        </p>
      </div>
    </div>
  </div>

  {{-- ลิงก์/รายการ --}}
  <div class="mx-auto max-w-7xl px-4 pb-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 pt-6">
      {{-- เมนูที่เกี่ยวข้อง + นโยบาย (ใช้ <details> บนมือถือให้เบา) --}}
      <div class="lg:col-span-3">
        <div class="hidden md:block">
          <h2 class="text-lg font-bold text-slate-800">เมนูที่เกี่ยวข้อง</h2>
          <ul class="mt-3 space-y-2 text-slate-700">
            <li><a href="https://nexttripholiday.com/about" class="hover:text-[#214e9a]">เกี่ยวกับเรา</a></li>
            <li><a href="https://nexttripholiday.com/aroundworld/0/0/0" class="hover:text-[#214e9a]">รอบรู้เรื่องเที่ยว</a></li>
            <li><a href="https://nexttripholiday.com/clients-company/0" class="hover:text-[#214e9a]">ลูกค้าของเรา</a></li>
            <li><a href="https://nexttripholiday.com/news/0/0" class="hover:text-[#214e9a]">ข่าวสารท่องเที่ยว</a></li>
            <li><a href="https://nexttripholiday.com/video/0/0" class="hover:text-[#214e9a]">วีดีโอท่องเที่ยว</a></li>
            <li><a href="https://nexttripholiday.com/clients-review/0/0" class="hover:text-[#214e9a]">คำรับรองจากลูกค้า</a></li>
            <li><a href="https://nexttripholiday.com/faq" class="hover:text-[#214e9a]">คำถามที่พบบ่อย</a></li>
            <li><a href="https://nexttripholiday.com/contact" class="hover:text-[#214e9a]">ติดต่อเรา</a></li>
          </ul>

          <h2 class="mt-6 text-lg font-bold text-slate-800">นโยบาย เงื่อนไขและข้อตกลง</h2>
          <ul class="mt-3 space-y-2 text-slate-700">
            @foreach($policy as $po)
              <li><a href="{{ url('policy') }}" class="hover:text-[#214e9a]">{{ $po->title }}</a></li>
            @endforeach
          </ul>
        </div>

        {{-- Mobile accordion (details) --}}
        <div class="md:hidden space-y-3">
          <details class="rounded-lg ring-1 ring-slate-200 bg-white">
            <summary class="cursor-pointer px-4 py-3 font-semibold">เมนูที่เกี่ยวข้อง</summary>
            <ul class="px-4 pb-3 space-y-2 text-slate-700 text-sm">
              <li><a href="https://nexttripholiday.com/about">เกี่ยวกับเรา</a></li>
              <li><a href="https://nexttripholiday.com/aroundworld/0/0/0">รอบรู้เรื่องเที่ยว</a></li>
              <li><a href="https://nexttripholiday.com/clients-company/0">ลูกค้าของเรา</a></li>
              <li><a href="https://nexttripholiday.com/news/0/0">ข่าวสารท่องเที่ยว</a></li>
              <li><a href="https://nexttripholiday.com/video/0/0">วีดีโอท่องเที่ยว</a></li>
              <li><a href="https://nexttripholiday.com/clients-review/0/0">คำรับรองจากลูกค้า</a></li>
              <li><a href="https://nexttripholiday.com/faq">คำถามที่พบบ่อย</a></li>
              <li><a href="https://nexttripholiday.com/contact">ติดต่อเรา</a></li>
            </ul>
          </details>

          <details class="rounded-lg ring-1 ring-slate-200 bg-white">
            <summary class="cursor-pointer px-4 py-3 font-semibold">นโยบาย เงื่อนไขและข้อตกลง</summary>
            <ul class="px-4 pb-3 space-y-2 text-slate-700 text-sm">
              @foreach($policy as $po)
                <li><a href="https://nexttripholiday.com/policy">{{ $po->title }}</a></li>
              @endforeach
            </ul>
          </details>
        </div>
      </div>

      {{-- ประเทศแยกทวีป (เบา ๆ) --}}
      <div class="lg:col-span-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
          @foreach($landmass as $land)
            @php
              $country = \App\Models\Backend\CountryModel::whereNull('deleted_at')
                          ->where('status','on')->where('landmass_id',$land->id)
                          ->orderBy('id','asc')->get();
            @endphp
            <div>
              <h2 class="text-lg font-bold text-slate-800">{{ $land->landmass_name }}</h2>
              <ul class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-slate-700">
                @foreach($country as $co)
                  <li>
                    <a href="https://nexttripholiday.com/oversea/{{$co->slug}}" class="inline-flex items-center gap-2 hover:text-[#214e9a]">
                      <img src="https://nexttripholiday.b-cdn.net/{{$co->img_icon}}" class="h-[18px] w-[24px] object-contain rounded-sm" alt="">
                      ทัวร์{{ $co->country_name_th }}
                    </a>
                  </li>
                @endforeach
              </ul>
            </div>
          @endforeach
        </div>
      </div>

      {{-- ข้อมูลบริษัท/ติดต่อ --}}
      <div class="lg:col-span-3">
        <h2 class="text-lg font-bold text-slate-800">บริษัท เน็กซ์ ทริป ฮอลิเดย์ จำกัด</h2>
        <div class="prose prose-sm max-w-none text-slate-700 mt-2">{!! $footer->detail !!}</div>

        <h4 class="mt-4 font-semibold text-slate-800">{!! $contact->service !!}</h4>
        <ul class="mt-2 space-y-2 text-slate-700">
          <li class="flex items-center gap-2">
            <img src="https://nexttripholiday.com/frontend/images/phonefooter.svg" alt="" class="h-4 w-4"> {{ $contact->phone_front }}
          </li>
          <li class="flex items-center gap-2">
            <img src="https://nexttripholiday.com/frontend/images/mailfooter.svg" alt="" class="h-4 w-4">
            <a href="mailto:{{ $contact->mail }}" class="hover:text-[#214e9a]">{{ $contact->mail }}</a>
          </li>
          <li class="flex items-center gap-2">
            <img src="https://nexttripholiday.com/frontend/images/line.svg" alt="" class="h-4 w-4">
            <a href="{{ $lineUrl }}" target="_blank" class="hover:text-[#214e9a]">{{ $contact->line_id }}</a>
          </li>
        </ul>

        <div class="mt-3 flex items-center gap-3">
          <a href="{{ $contact->link_fb }}" target="_blank"><img src="https://nexttripholiday.com/frontend/images/facebook.svg" class="h-6 w-6" alt="fb"></a>
          <a href="{{ $contact->link_yt }}" target="_blank"><img src="https://nexttripholiday.com/frontend/images/youtube.svg" class="h-6 w-6" alt="yt"></a>
          <a href="{{ $contact->link_ig }}" target="_blank"><img src="https://nexttripholiday.com/frontend/images/instagram.svg" class="h-6 w-6" alt="ig"></a>
          <a href="{{ $contact->link_tiktok }}" target="_blank"><img src="https://nexttripholiday.com/frontend/images/tiktok_ic.svg" class="h-6 w-6" alt="tiktok"></a>
        </div>
      </div>
    </div>

    {{-- แบนเนอร์ท้าย (ถ้ามี) --}}
    @if($footer->status == 'on')
      <div class="mt-8">
        <img src="https://nexttripholiday.b-cdn.net/{{ $footer->img_footer }}" alt="" class="w-full rounded-xl ring-1 ring-slate-200">
      </div>
    @endif
  </div>

  {{-- Copyright --}}
  <div class="bg-orange-500 text-center text-sm text-white py-4">
    Copyright © 2024 Next Trip Holiday, All Rights Reserved
  </div>
</section>

{{-- ===== Floating Support Bar (tiny JS only) ===== --}}
<div id="supportBar"
     class="hidden fixed right-4 bottom-4 z-40 w-[min(90vw,360px)] rounded-2xl bg-white ring-1 ring-slate-200 shadow-lg p-4">
  <button id="supportBarClose" class="absolute -top-2 -right-2 h-7 w-7 rounded-full bg-slate-800 text-white grid place-items-center">
    &times;
  </button>
  <div class="flex items-center gap-3">
    <img src="https://nexttripholiday.b-cdn.net/frontend/images/customer_sercvice.webp" alt="" class="h10 w-20 object-cover rounded-xl">
    <div class="text-sm">
      วันนี้เปิดบริการ <span class="text-[#f0742f] font-semibold">{{ $contact->service_time }}</span><br>
      <h5 class="font-bold text-slate-800">เน็กซ์ ทริป ฮอลิเดย์พร้อมให้บริการ</h5>
      <div class="text-lg font-extrabold text-[#214e9a]">{{ $contact->phone_front }}</div>
      <a href="{{ $lineUrl }}" target="_blank"
         class="mt-2 inline-flex items-center gap-2 rounded-full bg-[#00c300] px-3 py-1.5 text-white text-sm">
        <img src="https://nexttripholiday.b-cdn.net/frontend/images/line_share.svg" class="h-4 w-4" alt=""> {{ $contact->line_id }}
      </a>
    </div>
  </div>
</div>

<script>
  // เบามาก: ไม่มี jQuery
  (() => {
    // show/hide support bar on scroll
    const bar   = document.getElementById('supportBar');
    const close = document.getElementById('supportBarClose');
    const onScroll = () => {
      if (!bar) return;
      if (window.scrollY >= 300) bar.classList.remove('hidden');
      else bar.classList.add('hidden');
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    close?.addEventListener('click', () => bar.remove());

    // subscribe validate: กัน ".." ในอีเมล (ที่ HTML5 ไม่เช็ค)
    const form = document.getElementById('subscribeForm');
    form?.addEventListener('submit', (e) => {
      const email = document.getElementById('email');
      const err   = document.getElementById('error-message');
      const val   = (email?.value || '').trim();
      if (/\.\./.test(val)) {
        e.preventDefault();
        err.textContent = 'รูปแบบอีเมลไม่ควรมี ".."';
      } else {
        err.textContent = '';
      }
    });
  })();
</script>
