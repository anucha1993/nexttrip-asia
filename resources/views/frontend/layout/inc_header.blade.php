{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- ✅ Title -->
    <!-- ✅ Meta Description -->
    <meta name="description"
        content="แพ็กเกจทัวร์ญี่ปุ่น เกาหลี ไต้หวัน ราคาสุดคุ้ม เดินทางง่าย มีไฟลท์ตรง โรงแรมดี ไกด์มืออาชีพ จองกับ Next Trip Holiday พร้อมโปรโมชั่นพิเศษทุกเดือน">
    <!-- ✅ Meta Keywords -->
    <meta name="keywords"
        content="ทัวร์ญี่ปุ่น, ทัวร์เกาหลี, ทัวร์ไต้หวัน, ทัวร์ต่างประเทศ, แพ็กเกจทัวร์ราคาถูก, เที่ยวกับบริษัททัวร์, Next Trip Holiday">
    <!-- ✅ Open Graph สำหรับ Facebook, LINE -->
    <meta property="og:title" content="ทัวร์ญี่ปุ่น เกาหลี ไต้หวัน ราคาถูก | Next Trip Holiday" />
    <meta property="og:description"
        content="จองทัวร์กับบริษัททัวร์ชั้นนำ บินตรง โรงแรมดี เที่ยวสนุก ปลอดภัย ไกด์ดูแลตลอดทริป" />
    <meta property="og:url" content="https://www.nexttripholiday.com" />
    <meta property="og:type" content="website" />
    <!-- ✅ Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="ทัวร์ญี่ปุ่น เกาหลี ไต้หวัน ราคาถูก | Next Trip Holiday" />
    <meta name="twitter:description" content="โปรโมชั่นทัวร์ต่างประเทศ เดินทางง่าย บริการคุณภาพ จองเลย!" />
       <link type="text/css" rel="stylesheet" href="{{asset('frontend/css/layout.css')}}"/>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head> --}}

<!-- ✅ Title -->
  <title>@yield('title','Next Trip Holiday | บริษัททัวร์ต่างประเทศ ทัวร์เอเชีย ทัวร์ยุโรป รับจัดกรุ๊ปเหมาส่วนตัว')</title>
  <meta name="description" content="@yield('meta_description','แพลตฟอร์มจองทัวร์คุณภาพ ครบ จบ โปร่งใส')" />

<!-- ✅ Meta Description -->
<meta name="description" content="แพ็กเกจทัวร์ญี่ปุ่น เกาหลี ไต้หวัน ราคาสุดคุ้ม เดินทางง่าย มีไฟลท์ตรง โรงแรมดี ไกด์มืออาชีพ จองกับ Next Trip Holiday พร้อมโปรโมชั่นพิเศษทุกเดือน">

<!-- ✅ Meta Keywords -->
<meta name="keywords" content="ทัวร์ญี่ปุ่น, ทัวร์เกาหลี, ทัวร์ไต้หวัน, ทัวร์ต่างประเทศ, แพ็กเกจทัวร์ราคาถูก, เที่ยวกับบริษัททัวร์, Next Trip Holiday">

<!-- ✅ Open Graph สำหรับ Facebook, LINE -->
<meta property="og:title" content="ทัวร์ญี่ปุ่น เกาหลี ไต้หวัน ราคาถูก | Next Trip Holiday" />
<meta property="og:description" content="จองทัวร์กับบริษัททัวร์ชั้นนำ บินตรง โรงแรมดี เที่ยวสนุก ปลอดภัย ไกด์ดูแลตลอดทริป" />
<meta property="og:image" content="https://www.nexttripholiday.com/frontend/images/logo.png" />
<meta property="og:url" content="https://www.nexttripholiday.com" />
<meta property="og:type" content="website" />

<!-- ✅ Twitter Card -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="ทัวร์ญี่ปุ่น เกาหลี ไต้หวัน ราคาถูก | Next Trip Holiday" />
<meta name="twitter:description" content="โปรโมชั่นทัวร์ต่างประเทศ เดินทางง่าย บริการคุณภาพ จองเลย!" />
<meta name="twitter:image" content="https://www.nexttripholiday.com/frontend/images/logo.png" />

<!-- ✅ Canonical URL -->
<link rel="canonical" href="https://www.nexttripholiday.com" />


<link rel="canonical" href="https://www.nexttripholiday.com" />

    <meta property="og:image" content="{{asset('frontend/images/logo.png')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('frontend/css/layout.css')}}"/>
    <link type="image/ico" rel="shortcut icon" href="{{asset('frontend/images/favicon.ico')}}">
    <!-- Sweet Alert-->
    <link href="{{ asset('frontend/dist/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Toastr Alert-->
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/dist/toastr/toastr.min.css')}}" />


    
    <script src="{{asset('frontend/js/jquery.min.js')}}"></script>
    <script src="{{asset('frontend/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('frontend/js/jquery-ui.js')}}"></script>
    <script src="{{asset('frontend/js/modernizr.js')}}"></script>
    <script src="{{asset('frontend/js/slick.min.js')}}"></script>
    <script src="{{asset('frontend/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('frontend/js/jquery.fancybox.min.js')}}"></script>
    <script src="{{asset('frontend/js/popper.min.js')}}"></script>
    <script src="{{asset('frontend/js/jquery.flipster.min.js')}}"></script>
    
    <!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->
    <script src="//www.google.com/recaptcha/api.js?render=6LdQYyIqAAAAAB3FGzKTWhkYEHyPkR0oPovosbNs"></script>
    <!-- Sweet Alerts js -->
    <script src="{{ asset('frontend/dist/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Toastr Alert-->
    <script src="{{asset('frontend/dist/toastr/toastr.js')}}"></script>
     <!-- datepicker-->
    <script src="{{asset('frontend/js/datepicker.js')}}"></script>
    <script src="{{asset('frontend/js/daterangepicker.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/css/daterangepicker.css')}}"/>
    
    <script>
        $(document).ready(function() {
        // Show or hide the sticky footer button
        $(window).scroll(function() {
            if ($(this).scrollTop() > 300) {
            $('.go-top').fadeIn(300);
            } else {
            $('.go-top').fadeOut(300);
            }
        });

        // Animate the scroll to top
        $('.go-top').click(function(event) {
            event.preventDefault();

            $('html, body').animate({
            scrollTop: 0
            }, 800);
        })
        });

 </script>
 <!-- Google tag (gtag.js) -->
{{-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-YBTSPHPCDH"></script> --}}
{{-- <script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-YBTSPHPCDH');
</script> --}}

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-N65LVW7');</script>
<!-- End Google Tag Manager -->

     <!-- Your ปลั๊กอินแชท code -->
     {{--<div class="fb-customerchat" page_id="166748676864456" ></div>
    <script>
        window.fbAsyncInit = function () {
            FB.init({
                appId: '889213402583913',
                autoLogAppEvents: true,
                xfbml: true,
                version: 'v7.0'
            });
        };
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>--}}
     
    {{-- <div id="fb-customer-chat" class="fb-customerchat"></div>
    <script>
        var chatbox = document.getElementById('fb-customer-chat');
        chatbox.setAttribute("page_id", "163432046848877");
        chatbox.setAttribute("attribution", "biz_inbox");
        </script>

        <!-- Your SDK code -->
        <script>
        window.fbAsyncInit = function() {
            FB.init({
            xfbml            : true,
            version          : 'v18.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/th_TH/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script> --}}
<a href="#" class="go-top">  <span><i class="fas fa-angle-up"></i></span> </a>
    
    
    @if (session('alert'))
    <script type="text/javascript">
    $(function() { 
            Swal.fire({
                icon: "{!! session('alert.status') !!}",
                title: "{!! session('alert.msg') !!}",
                text: "",
                // showConfirmButton: false,
                // timer: 2000
            })
    });
    </script>
    @endif

    @if(Session::has('success'))
    <script type="text/javascript">
        $(function() {
            toastr.success("{{ session('success') }}");
        });
    </script>
    @endif

    @if(Session::has('error'))
    <script type="text/javascript">
        $(function() {
            toastr.error("{{ session('error') }}");
        });
    </script>
    @endif

    @if(Session::has('info'))
    <script type="text/javascript">
        $(function() {
            toastr.info("{{ session('info') }}");
        });
    </script>
    @endif

    @if(Session::has('warning'))
    <script type="text/javascript">
        $(function() {
            toastr.warning("{{ session('warning') }}");
        });
    </script>
    @endif


    <script type="text/javascript">
		$(document).ready(function() {
			$(".select-display-slide > li").click(function() {
				var rel = $(this).attr("rel");
				$('.display-slide').hide();
				$('.display-slide[rel=' + rel + ']').fadeIn();
				$(".select-display-slide > li").removeClass("active");
				$(this).addClass("active");
			});
		});
	</script>
<script>
$(document).ready(function(){
  const fixedAlt = "แพ็กเกจทัวร์ต่างประเทศ ญี่ปุ่น เกาหลี ไต้หวัน ราคาถูก | Next Trip Holiday";
  $("img").each(function(){
    if (!$(this).attr("alt") || $(this).attr("alt").trim() === "") {
      $(this).attr("alt", fixedAlt);
    }
  });
});
</script>



