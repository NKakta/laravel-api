@foreach($profiles as $profile)

    <div class="col-md-6 col-lg-4 mb-5">
        <div class="portfolio-item mx-auto" data-toggle="modal" data-target="#portfolioModal1">
            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
            </div>
            <img class="img-fluid" src="{{asset('assets/img/portfolio/giphy.gif')}}" alt="" />
            <h1>{{$profile->nickname}}</h1>
        </div>
    </div>

@endforeach
