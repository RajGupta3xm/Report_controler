@extends('admin.layout.master2')
@section('content')
      <section class="login_page">
         <div class="container-fluid px-0">
            <div class="row justify-content-center"> 
               <div class="col-4">
                  <div class="login_page_form shadow">
                     <div class="row">
                        <div class="col-12 formheader mb-4 text-center">
                           <img src="{{asset('assets/img/logo.png')}}" alt="">
                           <h1>Choose Your Language</h1> 
                        </div>
                        <div class="col-12">
                           <form class="row form-design" action="">
                              <div class="language">
                                 <div id="google_translate_element"></div>
                                  <div class="language_bax">
                                     <div class="flag-lists translation-links d-flex justify-content-center p-0 w-100"> 
                                        <a class="english shadow" data-lang="English" href="javscript:;">
                                           <img class="mr-md-2 ml-md-0 ml-1 flag_img" src="{{asset('assets/img/united-kingdom.png')}}">
                                           <span>English</span>
                                        </a> 
                                        <a class="arabic shadow" data-lang="Arabic" href="javscript:;">
                                           <img class="mr-md-2 ml-md-0 ml-1 flag_img" src="{{asset('assets/img/united-arab-emirates.png')}}">
                                           <span>Arabic</span>
                                        </a> 
                                     </div>
                                  </div>
                                  <div id="google_translate_element"></div>
                              </div>
                              <div class="form-group col-12 text-center mt-4 pt-3">
                                  <a class="comman_btn" href="{{url('admin/dashboard')}}">Continue</a>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      @endsection

      <div id="google_translate_element"></div>
      <script type="text/javascript">
         function googleTranslateElementInit() {
               new google.translate.TranslateElement({
                  pageLanguage: 'en',
                  layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                  autoDisplay: false
               }, 'google_translate_element');
         }
      </script>
      <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" type="text/javascript"></script>
      <!-- Flag click handler -->
      <script type="text/javascript">
         $('.translation-links a').click(function() {
               var lang = $(this).data('lang');
               var $frame = $('.goog-te-menu-frame:first');
               // if (!$frame.size()) {
               // alert("Error: Could not find Google translate frame.");
               // return false;
               // }
               $frame.contents().find('.goog-te-menu2-item span.text:contains(' + lang + ')').get(0).click();
               var removePopup = document.getElementById('goog-gt-tt');
               if(removePopup){
                  removePopup.parentNode.removeChild(removePopup);
               }
               return false;
         });
      </script>

  