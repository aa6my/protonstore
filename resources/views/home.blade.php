 @extends('layouts.app')

 @section('links')
     <link href="{{ asset('css/home.css') }}" rel="stylesheet">
 @endsection
 
 @section('bodyID')
 {{ 'home' }}@endsection
 
 @section('navTheme')
 {{ 'dark' }}@endsection
 
 @section('logoFileName')
 {{ URL::asset('/images/proton.png') }}@endsection
 
 
 @section('content')
 <section class="banner">
     <div class="container">
         <div class="col-md-10 col-lg-8 details">
             <h3>Tolles Hightech-Auto</h3>
             <h1>Das Auto ist unübertroffen if you are in Asia</h1>
             <a href="{{ route('car') }}" class="btn primary-btn" style="width:250px;">Discover car</a>
         </div>
     </div>
 </section>
 
 <section class="chefs">
     <div class="container">
         <!-- <h2 class="title flex-center">Cars</h2> -->
         <div class="row justify-content-evenly align-items-center">
             <div class="col-lg-12 col-md-12">
                 <div class="chef-img d-flex align-items-center justify-content-center">
                     <img src="./images/x50-0001.png" alt="">
                 </div>
                 <div class="chef-desc d-flex flex-column align-items-center justify-content-start">
                     <p class="chef-name">Proton X50</p>
                     <p class="chef-position">Intelligence That Amazes</p>
                 </div>
             </div>
             <div class="col-lg-12 col-md-12">
                 <div class="chef-img d-flex align-items-center justify-content-center">
                     <img src="./images/x70-0001.png" alt="">
                 </div>
                 <div class="chef-desc d-flex flex-column align-items-center justify-content-start">
                     <p class="chef-name">Proton x70</p>
                     <p class="chef-position">Intelligence That Inspires</p>
                 </div>
             </div>
             <div class="col-lg-12 col-md-12">
                 <div class="chef-img d-flex align-items-center justify-content-center">
                     <img src="./images/x90-0001.png" alt="">
                 </div>
                 <div class="chef-desc d-flex flex-column align-items-center justify-content-start">
                     <p class="chef-name">Proton x90</p>
                     <p class="chef-position">Intelligence That Buffy</p>
                 </div>
             </div>
         </div>
     </div>
 </section>
 
 <section class="contact">
     <div class="container">
         <!-- <h2 class="title flex-center">Contact Us</h2> -->
         <div class="flex-center contact-wrapper">
         <div class="form-wrapper flex-center">
             <form>
                 <div class="mb-3">
                     <label for="name" class="form-label">Name</label>
                     <input type="text" class="form-control" id="name" aria-describedby="emailHelp">
                 </div>
                 <div class="mb-3">
                     <label for="email" class="form-label">Email</label>
                     <input type="email" class="form-control" id="email">
                     <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                 </div>
                 <div class="mb-3">
                     <label for="message" class="form-label">Message</label>
                     <textarea class="form-control" id="message" style="height: 100px"></textarea>
                 </div>
                 <div class="w-100 flex-center">
                 <a href="mailto:zensushi.sdp@gmail.com" class="primary-btn msg-btn w-100 px-3 py-2 text-center rounded">
                     Send Message
                 </a>
                 </div>
             </form>
         </div>
 
         <div class="gmap flex-center">
             <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15936.857188446978!2d101.5637477!3d3.0371195!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x346a2d233385cb3a!2sProton%20Hicom%20Factory!5e0!3m2!1sen!2smy!4v1659446393848!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" class="rounded"></iframe>
         </div>
 
         </div>
     </div>
 </section>
 @endsection