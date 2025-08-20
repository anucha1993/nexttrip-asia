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
            </div>
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