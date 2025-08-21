<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include("frontend.layout.inc_header")
</head>

<body>
    @include("frontend.layout.inc_topmenu")
    <section id="aboutpage" class="wrapperPages">
        <div class="container-fluid g-0 overflow-hidden">
           
            <div class="row">
                <div class="col">
                    <div class="bannereach">
                        <img src="{{asset($banner->img)}}" alt="">
                        <div class="bannercaption">
                            {!! $banner->detail !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col contentde text-center">
                       {!! $about->detail  !!}
                   <style>
    /* CSS Styles for the content sections */
    .content-section {
        text-align: center;
        font-family: 'Sarabun', sans-serif; /* แนะนำให้ใส่ฟอนต์ Sarabun ในเว็บไซต์ของคุณ */
        color: #444;
        line-height: 1.6;
        padding: 30px 20px;
        max-width: 900px;
        margin: 0 auto; /* จัดกึ่งกลางเนื้อหา */
        background-color: #fff; /* เพิ่มพื้นหลังสีขาวให้เนื้อหา */
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); /* เพิ่มเงาเล็กน้อย */
        margin-bottom: 30px; /* เพิ่มระยะห่างระหว่าง block */
    }

    .section-title {
        font-size: 2.2rem;
        color: #004d99; /* สีน้ำเงินเข้ม */
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 10px;
        font-weight: bold;
    }

    .section-title::after {
        content: '';
        width: 60px;
        height: 4px;
        background-color: #ffc107; /* สีเหลืองทอง */
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 2px;
    }

    .section-paragraph {
        font-size: 1.1rem;
        color: #666;
        margin-bottom: 20px;
    }

    .features-list {
        list-style-type: none;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
    }

    .features-list li {
        font-size: 1.1rem;
        color: #333;
        background-color: #f0f8ff; /* สีฟ้าอ่อน */
        padding: 15px 25px;
        border-radius: 8px;
        width: 100%;
        max-width: 600px;
        text-align: left;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
    }

    .features-list li::before {
        content: '✓';
        color: #28a745; /* สีเขียว */
        font-size: 1.3rem;
        font-weight: bold;
        margin-right: 15px;
    }

    .info-list {
        list-style-type: none;
        padding: 0;
        text-align: left;
        max-width: 600px;
        margin: 0 auto;
    }

    .info-list li {
        margin-bottom: 10px;
        font-size: 1.1rem;
        color: #555;
    }

    .info-list li strong {
        color: #004d99;
    }

    .image-block {
        margin-top: 40px;
        padding: 20px;
        background-color: #f8f8f8;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .image-block img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin-bottom: 20px; /* ระยะห่างระหว่างรูป */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .image-block .image-title {
        font-size: 1.5rem;
        color: #004d99;
        margin-bottom: 25px;
        font-weight: bold;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .section-title {
            font-size: 1.8rem;
        }
        .section-paragraph, .features-list li, .info-list li {
            font-size: 1rem;
        }
        .features-list li {
            padding: 10px 15px;
        }
    }
</style>


    <!-- Clients / Trusted by -->
<section class="py-5 py-md-6 bg-light">
  <div class="container">
    <!-- Heading -->
    <div class="text-center mb-4 mb-md-5">
      {{-- <span class="badge rounded-pill bg-warning-subtle text-warning-emphasis px-3 py-2 mb-2">Our Clients</span> --}}
      <h2 class="h3 h1-md fw-bold text-dark mb-2">ขอบคุณทุกองค์กร <span class="text-orange">ที่ร่วมเดินทางไปกับเรา</span></h2>
      <p class="text-muted mb-0">Next Trip Holiday</p>
    </div>

    <!-- Logo Grid -->
    <div class="row g-3 g-md-4 row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6">
      @foreach($customer as $cus)
      <div class="col">
        <a href="{{ url('clients-detail/'.$cus->id) }}" class="text-decoration-none d-block client-card" aria-label="ดูรายละเอียดลูกค้า">
          <div class="logo-box d-flex align-items-center justify-content-center rounded-4 border bg-white">
            <img
              src="{{ asset($cus->logo) }}"
              alt="{{ $cus->name ?? 'ลูกค้า' }}"
              class="img-fluid client-logo"
              loading="lazy"
            >
          </div>
        </a>
      </div>
      @endforeach
    </div>
  </div>
</section>

<style>
  /* สีส้มหลัก (ปรับได้ตามแบรนด์) */
  .text-orange { color: #f97316; }

  /* กล่องโลโก้: อัตราส่วน 3:2 ให้ดูสมดุลบนทุกหน้าจอ */
  .logo-box { 
    aspect-ratio: 3 / 2;
    padding: .75rem;
    transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
    border-color: rgba(0,0,0,.06) !important;
    box-shadow: 0 4px 14px rgba(0,0,0,.04);
  }

  /* โลโก้: เทาเล็กน้อย + โปร่งนิดนึง เพื่อความเรียบ */
  /* .client-logo {
    max-height: 64px;          /* กันโลโก้สูงเกิน (ปรับได้) */
    object-fit: contain;
    filter: grayscale(100%) contrast(1) brightness(1.05);
    opacity: .8;
    transition: filter .25s ease, opacity .25s ease, transform .25s ease;
  } */

  /* Hover/Focus: ยกนิด ๆ เปลี่ยนเป็นสี */
  .client-card:hover .logo-box,
  .client-card:focus .logo-box {
    transform: translateY(-3px);
    border-color: rgba(249,115,22,.35) !important; /* ส้ม */
    box-shadow: 0 10px 22px rgba(249,115,22,.12);
  }
  .client-card:hover .client-logo,
  .client-card:focus .client-logo {
    filter: none;
    opacity: 1;
    transform: scale(1.02);
  }

  /* ปรับขนาดโลโก้ตามจอให้บาลานซ์ */
  @media (min-width: 768px) {
    .client-logo { max-height: 72px; }
  }
  @media (min-width: 1200px) {
    .client-logo { max-height: 76px; }
  }
</style>





                </div>
            </div>


            

            <script>
$(function () {
  $('img[src*="moxieupload/"]').each(function () {
    var s = $(this).attr('src');
    var abs = new URL(s, location.href);
    var i = abs.pathname.toLowerCase().indexOf('/moxieupload/');
    if (i !== -1) {
      var path = abs.pathname.slice(i + 1).replace(/^\//, '');
      $(this).attr('src', 'https://nexttrip.b-cdn.net/' + path);
    }
  });
});
</script>
{{-- 

            <div class="row g-0 mt-5">
                <div class="col-md-6 abtsect">
                    <img src="{{asset($about->img_left)}}" class="img-fluid" alt="">
                    <div class="abttext">
                        {!! $about->text_left  !!}
                    </div>
                </div>
                <div class="col-md-6 abtsect">
                    <img src="{{asset($about->img_right)}}" class="img-fluid" alt="">
                    <div class="abttext2">
                        {!! $about->text_right  !!}
                    </div>
                </div>
            </div> --}}
        </div>

    
        

        <div class="container">
            <div class="row mt-5">
                <div class="col Cropscroll">
                    <div class="listtourid select-display-slide">
                        <li class="active" rel="1">
                            <a href="javascript:void(0)">
                                ข้อมูลการจัดตั้งบริษัท </a>
                        </li>
                        <li rel="2">
                            <a href="javascript:void(0)">
                                ธุรกิจหลักของบริษัท </a>
                        </li>
                        <li rel="3">
                            <a href="javascript:void(0)">
                                กลุ่มลูกค้าบริษัท</a>
                        </li>

                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col">
                    <div class="display-slide" rel="1" style="display:block;">
                        <div class="abtslide owl-theme owl-carousel">
                            @foreach($licen as $li)
                            <div class="item text-center">
                                <div class="boxwhiteshd  hoverstyle">
                                    <figure>
                                        <a href="#"><img src="{{asset($li->img)}}" class="img-fluid" alt=""></a>
                                    </figure>
                                    <p style="font-size: 14px;">{{$li->detail}}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="display-slide" rel="2">
                        @foreach($business as $b => $bu)
                        <div class="row">
                            <div class="col-lg-4 offset-lg-4 businessdetails">
                                <li class="listnumber"><span>0{{$b+1}}</span> {{$bu->list}}</li>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="display-slide" rel="3">
                        @foreach($group as $g => $gro)
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2 businessdetails">
                                <li class="listnumber"><span>0{{$g+1}}</span>{{$gro->list}}</li>  
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row mt-5 mb-4">
                <div class="col">
                    <div class="titletopic text-center">
                        <h2>รางวัลที่ได้รับ</h2>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col">
                    <div class="awardsslider owl-theme owl-carousel">
                        @foreach($award as $aw)
                        <div class="item">
                            <div class="hoverstyle">
                                <figure>
                                    <a href="#"><img src="{{asset($aw->img)}}" class="img-fluid" alt=""></a>
                                </figure>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include("frontend.layout.inc_footer")

    <script>
        $(document).ready(function () {
            $('.awardsslider').owlCarousel({
                loop: true,
                autoplay: false,
                smartSpeed: 2000,
                nav: true,
                navText: ['<img src="{{url('frontend/images/arrowRight.svg')}}">', '<img src="{{url('frontend/images/arrowLeft.svg')}}">'],
                navClass: ['owl-prev', 'owl-next'],
                dots: false,
                margin: 20,
                responsive: {
                    0: {
                        items: 2,


                    },
                    600: {
                        items: 3,
                        slideBy: 1,

                    },
                    1024: {
                        items: 4,
                        slideBy: 1
                    },
                    1200: {
                        items: 4,
                        slideBy: 1
                    }
                }
            })
            $('.abtslide').owlCarousel({
                loop: true,
                autoplay: false,
                smartSpeed: 2000,
                nav: true,
                navText: ['<img src="{{url('frontend/images/arrowRight.svg')}}">', '<img src="{{url('frontend/images/arrowLeft.svg')}}">'],
                navClass: ['owl-prev', 'owl-next'],
                dots: false,
                margin: 10,
                responsive: {
                    0: {
                        items: 1,


                    },
                    600: {
                        items: 2,
                        slideBy: 1,

                    },
                    1024: {
                        items: 3,
                        slideBy: 1
                    },
                    1200: {
                        items: 3,
                        slideBy: 1
                    }
                }
            })


        });
    </script>

</body>

</html>