<!doctype html>
<html lang="th" class="scroll-smooth antialiased">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title','TourBooking')</title>
  <meta name="description" content="@yield('meta_description','แพลตฟอร์มจองทัวร์คุณภาพ ครบ จบ โปร่งใส')" />

  {{-- ถ้าจะใช้รูป preload คงไว้ได้ --}}
  <link rel="preconnect" href="https://images.unsplash.com" crossorigin />
  <link rel="dns-prefetch" href="//images.unsplash.com" />
  <link rel="preload" as="image" fetchpriority="high"
        href="https://images.unsplash.com/photo-1499002238440-d264edd596ec?auto=format&fit=crop&w=1400&q=60"
        imagesrcset="https://images.unsplash.com/photo-1499002238440-d264edd596ec?auto=format&fit=crop&w=800&q=60 800w,
                     https://images.unsplash.com/photo-1499002238440-d264edd596ec?auto=format&fit=crop&w=1400&q=60 1400w"
        imagesizes="100vw" />

  {{-- Critical CSS (ตามเดิม) --}}
  <style>
    .cv{content-visibility:auto;contain-intrinsic-size:600px 1000px;}
    @media (prefers-reduced-motion:reduce){
      *{animation-duration:.001ms!important;animation-iteration-count:1!important;transition:none!important;}
    }
  </style>
  <style>
    html{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji"}
    body{margin:0;line-height:1.5;-webkit-font-smoothing:antialiased}
    h1,h2,h3{font-weight:600;margin:0}
    a{text-decoration:none}
    .btn-orange{display:inline-flex;align-items:center;justify-content:center;border-radius:9999px;background:#ea580c;color:#fff;font-weight:600;padding:.75rem 1.75rem;font-size:.875rem}
    .btn-orange:hover{background:#c2410c}
    header.sticky{backdrop-filter:blur(12px)}
  </style>
 {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
  {{-- ✅ ใช้ไฟล์ static ที่คัดลอกไว้ใน public/newhome/css --}}
  <link rel="preload" href="newhome/build/assets/app-C1rIRth3.css" as="style" />
  <link rel="stylesheet" href="newhome/build/assets/app-C1rIRth3.css" />
  <link rel="stylesheet" href="newhome/build/assets/app-C1rIRth3.css" />
  <noscript><link rel="stylesheet" href="newhome/build/assets/app-C1rIRth3.css"/></noscript>

  {{-- ถ้าต้องใช้ Font Awesome ให้ลิ้งค์จากไฟล์ที่คัดลอกไว้เอง หรือ CDN นี้ก็ได้ --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
{{-- @php $appCss = Vite::asset('resources/newhome/css/app.css'); @endphp --}}
  <meta name="theme-color" content="#ea580c" />
</head>
<body class="font-sans bg-white text-slate-700 dark:bg-slate-900 dark:text-slate-100">
  <div id="app" class="min-h-screen flex flex-col">
    {{-- ✅ ปรับ path include ให้ตรงกับโฟลเดอร์ newhome/partials --}}
    @includeIf('newhome.partials.nav')

    <main class="flex-1">
      @yield('content')
    </main>

    
    @includeIf('newhome.partials.footer')
  </div>

  {{-- ✅ JS แบบไฟล์ static (ถ้ามี) --}}
  <script defer src='newhome/build/assets/app-l0sNRNKZ.js'></script>
</body>
</html>
