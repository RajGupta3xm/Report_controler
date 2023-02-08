
<!DOCTYPE html>
<html lang="en">

    <head>
 
    <meta charset="utf-8" />
      <meta content="width=device-width, initial-scale=1.0" name="viewport" />
      <title>diet-on : Admin Panel</title>
      <meta content="" name="description" />
      <meta content="" name="keywords" />
        <link href="{{asset('assets/img/favicon.png')}}" rel="icon" />
      <link href="{{asset('assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon" />
      <!-- Vendor CSS Files -->
      
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
      <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet"/>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" /> 
      <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet" />
      <link href="{{asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet" />
      <link href="{{asset('assets/vendor/owl/owl.carousel.min.css')}}" rel="stylesheet" />
      <link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.15.1/css/pro.min.css"/>

     
      <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" />
      
      
      <!-- <link  href="{{asset('assets/admin/plugins/datatables/css/dataTables.bootstrap.min.css')}}" rel="stylesheet"> -->
      <!-- <link rel="stylesheet" href="{{asset('assets/admin/css/style.css')}}"> -->
      
        <style>
            .loading img {
    max-width: 174px;
}
.loader_inner .text {
    color: #ffb91d;
}
.loader_inner {
    margin-top: -17px;
}
.loading {
    position: fixed;
    background: #fff;
    height: 100vh;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 99999;
    text-align: center;
}
.text {
  color: #A40501;
  display: inline-block;
  margin-left: 5px;
  font-weight: bold;
}
.bounceball {
  position: relative;
  display: inline-block;
  height: 37px;
  width: 15px;
}
.bounceball:before {
  position: absolute;
  content: "";
  display: block;
  top: 0;
  width: 15px;
  height: 15px;
  border-radius: 50%;
  background-color: #ffb91d;
  transform-origin: 50%;
  -webkit-animation: bounce 500ms alternate infinite ease;
          animation: bounce 500ms alternate infinite ease;
}
@-webkit-keyframes bounce {
  0% {
    top: 30px;
    height: 5px;
    border-radius: 60px 60px 20px 20px;
    transform: scaleX(2);
  }
  35% {
    height: 15px;
    border-radius: 50%;
    transform: scaleX(1);
  }
  100% {
    top: 0;
  }
}
@keyframes bounce {
  0% {
    top: 30px;
    height: 5px;
    border-radius: 60px 60px 20px 20px;
    transform: scaleX(2);
  }
  35% {
    height: 15px;
    border-radius: 50%;
    transform: scaleX(1);
  }
  100% {
    top: 0;
  }
}
            .loader {
                text-align: center;
                vertical-align: middle;
                position: fixed;
                display: flex;
                background: #fdfbfb;
                padding: 100px;
                box-shadow: 0px 40px 60px -20px rgba(0, 0, 0, 0.2);
                width:100%;
                z-index:500000;
                height: 100%;
                padding-left: 43%;
                padding-top: 30%;
            }

            .loader span {
                display: block;
                width: 20px;
                height: 20px;
                background: #ffb91d;
                border-radius: 50%;
                margin: 0 5px;
                margin-top: 85px;
                box-shadow: 0 2px 2px rgba(0, 0, 0, 0.2);
            }


            .loader span:nth-child(2) {
                background: #f07e6e;
            }

            .loader span:nth-child(3) {
                background: #84cdfa;
            }

            .loader span:nth-child(4) {
                background: #5ad1cd;
            }

            .loader span:not(:last-child) {
                animation: animate 1.5s linear infinite;
            }

            @keyframes animate {
                0% {
                    transform: translateX(0);
                }

                100% {
                    transform: translateX(30px);
                }
            }

            .loader span:last-child {
                animation: jump 1.5s ease-in-out infinite;
            }

            @keyframes jump {
                0% {
                    transform: translate(0, 0);
                }
                10% {
                    transform: translate(10px, -10px);
                }
                20% {
                    transform: translate(20px, 10px);
                }
                30% {
                    transform: translate(30px, -50px);
                }
                70% {
                    transform: translate(-150px, -50px);
                }
                80% {
                    transform: translate(-140px, 10px);
                }
                90% {
                    transform: translate(-130px, -10px);
                }
                100% {
                    transform: translate(-120px, 0);
                }
            }


            .loaderDiv{
                position: fixed;
    z-index: 5000000000001;
    text-align: center;
    top: 40%;
    left: 40%;
            }

            .loaderDiv p{
                color:#ec1d38!important;
            }
        </style>
    </head>
    <body class="skin-blue sidebar-mini">
        <div id="preloader">
            <div class="loading">
               <div class="">
                    <img class="mb-2" src="{{asset('assets/img/logo.png')}}" alt="logo">
                   <div class="loader_inner">
                        <div class="bounceball"></div>
                        <div class="text">Please wait while page is loading......</div>
                   </div>
               </div>
            </div>
        </div>
        <!-- <div class="loading loaderDiv">
            <img class="mb-2" style="width: 20%; margin-right: 65%;" src="{{asset('assets/admin/images/logo.png')}}" alt="logo">
            <p style=" margin-right: 65%;">Please wait while page is loading..</p>
        </div>
        <div class="loading loader">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div> -->
        <div class="wrapper boxed-wrapper">

            <!-- Navbar -->
            @include('admin.layout.header')
            <!-- /.navbar -->
            <!-- Main Sidebar Container -->
            <!-- <div class="dashboard-section"> -->
            @include('admin.layout.sidebar')
            <!-- Content Wrapper. Contains page content -->
            <!-- <div class="content-wrapper"> -->
            <!-- <div id="loader" class="lds-dual-ring hidden overlay"></div> -->
            <!-- Content Header (Page header) -->
            @yield('content')
            <!-- /.content-header -->
            <!-- </div> -->
            <!-- Main Footer -->
            @include('admin.layout.footer')
            <!-- </div> -->
            <!-- /.content-wrapper -->

        </div>
        
        <script>
           
            $(window).on("load", function () {
                if ($("#preloader").length) {
                $("#preloader")  .delay(300) .fadeOut("slow", function () {
                    $(this).remove();
                });
                }
            });
        </script>



         <script src="{{asset('assets/vendor/jquery.min.js')}}"></script>
      <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
      <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
      <script src="{{asset('assets/vendor/owl/owl.carousel.min.js')}}"></script> 
      <script src="{{asset('assets/js/jquery.multi-select.js')}}"></script>
    
       <script src="{{asset('assets/js/main.js')}}"></script>
       <script src="{{asset('assets/admin/js/demo.js')}}"></script>
    <!-- filter script  -->
    <script src="{{asset('assets/admin/plugins/functions/dashboard1.js')}}"></script>
    <script src="{{asset('assets/admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/admin/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<!-- end filter script -->
      <script type="text/javascript">
         $(function () {
               $('#dtpickerdemo').datetimepicker();
         });
       </script>
       
       <script>
         var divs = ["Menu1", "Menu2",];
          var visibleDivId = null;
          function toggleVisibility(divId) {
          if(visibleDivId === divId) {
             //visibleDivId = null;
          } else {
             visibleDivId = divId;
          }
          hideNonVisibleDivs();
          }
          function hideNonVisibleDivs() {
          var i, divId, div;
          for(i = 0; i < divs.length; i++) {
             divId = divs[i];
             div = document.getElementById(divId);
             if(visibleDivId === divId) {
                div.style.display = "block";
             } else {
                div.style.display = "none";
             }
          }
          }
      </script>
      <script>
         $( '.multiple-select-custom-field' ).select2( {
           theme: "bootstrap-5",
           width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
           placeholder: $( this ).data( 'placeholder' ),
           closeOnSelect: false,
           tags: true
        } );
     </script>
     
        <script type="text/javascript">
            $(".chosen").chosen();
        </script>
        <script>
            $(".my-select").chosenImage({
                disable_search_threshold: 10
            });
        </script>
        <script type="text/javascript">
            var $loading = $('.loading').hide();
            $(document)
                    .ajaxStart(function () {
                        //ajax request went so show the loading image
                        $loading.show();
                    })
                    .ajaxStop(function () {
                        //got response so hide the loading image
                        $loading.hide();

                    });

            $(document).ready(function () {
                $('#example-getting-started').multiselect({
                    numberDisplayed: 1,
                    includeSelectAllOption: true,
                    allSelectedText: 'All Topics selected',
                    nonSelectedText: 'No Topics selected',
                    selectAllValue: 'all',
                    selectAllText: 'Select all',
                    unselectAllText: 'Unselect all',
                    onSelectAll: function (checked) {
                        var all = $('#example-getting-started ~ .btn-group .dropdown-menu .multiselect-all .checkbox');
                        all
                                // get all child nodes including text and comment
                                .contents()
                                // iterate and filter out elements
                                .filter(function () {
                                    // check node is text and non-empty
                                    return this.nodeType === 3 && this.textContent.trim().length;
                                    // replace it with new text
                                }).replaceWith(checked ? this.unselectAllText : this.selectAllText);
                    },
                    onChange: function () {
                        debugger;
                        var select = $(this.$select[0]);
                        var dropdown = $(this.$ul[0]);
                        var options = select.find('option').length;
                        var selected = select.find('option:selected').length;
                        var all = dropdown.find('.multiselect-all .checkbox');
                        all
                                // get all child nodes including text and comment
                                .contents()
                                // iterate and filter out elements
                                .filter(function () {
                                    // check node is text and non-empty
                                    return this.nodeType === 3 && this.textContent.trim().length;
                                    // replace it with new text
                                }).replaceWith(options === selected ? this.options.unselectAllText : this.options.selectAllText);
                    }
                });

                $("#form").submit(function (e) {
                    e.preventDefault();
                    alert($(this).serialize());
                });
            });


        </script>
        <script>
            $(function () {
                $('#example1').DataTable()
                $('#example2').DataTable()
                $('#example4').DataTable()
                $('#example5').DataTable()
                $('#example3').DataTable({
                    'paging': true,
                    'lengthChange': false,
                    'searching': false,
                    'ordering': true,
                    'info': true,
                    'autoWidth': false
                })
            })
        </script>
        <script>
            var frmRes = $('#frmRes');
            var frmResValidator = frmRes.validate();

            var frmInfo = $('#frmInfo');
            var frmInfoValidator = frmInfo.validate();

            var frmLogin = $('#frmLogin');
            var frmLoginValidator = frmLogin.validate();

            var frmMobile = $('#frmMobile');
            var frmMobileValidator = frmMobile.validate();

            $('#demo1').steps({
                onChange: function (currentIndex, newIndex, stepDirection) {
                    console.log('onChange', currentIndex, newIndex, stepDirection);
                    // tab1
                    if (currentIndex === 0) {
                        if (stepDirection === 'forward') {
                            var valid = frmRes.valid();
                            return valid;
                        }
                        if (stepDirection === 'backward') {
                            frmResValidator.resetForm();
                        }
                    }

                    // tab2
                    if (currentIndex === 1) {
                        if (stepDirection === 'forward') {
                            var valid = frmInfo.valid();
                            return valid;
                        }
                        if (stepDirection === 'backward') {
                            frmInfoValidator.resetForm();
                        }
                    }

                    // tab3
                    if (currentIndex === 2) {
                        if (stepDirection === 'forward') {
                            var valid = frmLogin.valid();
                            return valid;
                        }
                        if (stepDirection === 'backward') {
                            frmLoginValidator.resetForm();
                        }
                    }

                    // tab4
                    if (currentIndex === 3) {
                        if (stepDirection === 'forward') {
                            var valid = frmMobile.valid();
                            return valid;
                        }
                        if (stepDirection === 'backward') {
                            frmMobileValidator.resetForm();
                        }
                    }

                    return true;

                },
                onFinish: function () {
                    alert('Wizard Completed');
                }
            });
        </script> 
        <script>
            $('#demo').steps({
                onFinish: function () {
                    alert('Wizard Completed');
                }
            });
        </script>

          <script>
         $( '.selct_comman' ).select2( {
            theme: "bootstrap-5", 
         });
      </script>
      
        <script>
            $(document).ready(function () {
                // Basic
                $('.dropify').dropify();

                // Translated
                $('.dropify-fr').dropify({
                    messages: {
                        default: 'Glissez-déposez un fichier ici ou cliquez',
                        replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                        remove: 'Supprimer',
                        error: 'Désolé, le fichier trop volumineux'
                    }
                });

                // Used events
                var drEvent = $('#input-file-events').dropify();

                drEvent.on('dropify.beforeClear', function (event, element) {
                    return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
                });

                drEvent.on('dropify.afterClear', function (event, element) {
                    alert('File deleted');
                });

                drEvent.on('dropify.errors', function (event, element) {
                    console.log('Has Errors');
                });

                var drDestroy = $('#input-file-to-destroy').dropify();
                drDestroy = drDestroy.data('dropify')
                $('#toggleDropify').on('click', function (e) {
                    e.preventDefault();
                    if (drDestroy.isDropified()) {
                        drDestroy.destroy();
                    } else {
                        drDestroy.init();
                    }
                })
            });
        </script>
        <script>
            $(function () {
                //Add text editor
                $("#compose-textarea").wysihtml5();
            });
        </script>
     
        <!-- <script>
            var imgflag = true;
            $(document).ready(function () {

                $(".alphanum").keypress(function (e) {
                    var specialKeys = new Array();
                    specialKeys.push(8); //Backspace
                    specialKeys.push(9); //Tab
                    specialKeys.push(46); //Delete
                    specialKeys.push(36); //Home
                    specialKeys.push(35); //End
                    specialKeys.push(37); //Left
                    specialKeys.push(39); //Right
                    var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
                    var ret = ((keyCode >= 48 && keyCode <= 57) || (keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122) || (keyCode == 124) || (keyCode == 58) || (keyCode >= 37 && keyCode <= 46) || (keyCode == 32) || (specialKeys.indexOf(e.keyCode) != -1 && e.charCode != e.keyCode));

                    if (ret == true) {
                        return true;
                    } else {
                        e.preventDefault();
                        return false;
                    }

                });

                // $('.arabicinput').keyup(function(e){
                //      var specialKeys = new Array();
                //     specialKeys.push(8); //Backspace
                //     specialKeys.push(9); //Tab
                //     specialKeys.push(46); //Delete
                //     specialKeys.push(36); //Home
                //     specialKeys.push(35); //End
                //     specialKeys.push(37); //Left
                //     specialKeys.push(39); //Right
                //     // var unicode=e.charCode? e.charCode : e.keyCode
                //     var unicode = e.keyCode == 0 ? e.charCode : e.keyCode;

                //     var ret=(( unicode<48 || unicode>57) || (unicode < 0x0600 || unicode > 0x06FF) || (unicode == 124) || (unicode == 58) || (unicode >= 37 && unicode <= 46) || (specialKeys.indexOf(e.keyCode) != -1 && e.charCode != e.keyCode));
                //         alert(ret);
                //         if (ret){
                //             return true;
                //         } else{
                //             e.preventDefault();
                //             return false;
                //         }
                // });
            });

            function checkPrice(element) {
                if (isNaN(element.val())) {
                    return false;
                } else {
                    return true;
                }
            }

            function validImage(obj, wi, hi) {
                var _URL = window.URL || window.webkitURL;
                var file = $(obj).prop('files')[0];
                var img = new Image();
                var min_wi = parseInt(wi) - 50;

                img.onload = function () {
                    var wid = this.width;
                    var ht = this.height;
                    if ((wid < min_wi || wid > wi) || ht !== hi) {
                        imgflag = false;
                    } else {
                        imgflag = true;
                    }
                };
                img.src = _URL.createObjectURL(file);
            }
        </script> -->
        <!-- <script>
            var langArray = [];
            $('.vodiapicker option').each(function () {
                var img = $(this).attr("data-thumbnail");
                var text = this.innerText;
                var value = $(this).val();
                var dis = $(this).attr("disabled");
                if (dis == "disabled") {
                    var item = '<li><span style="margin-left:15px;">' + text + '</span></li>';
                } else {
                    var item = '<li><img src="' + img + '" alt="" value="' + value + '"/><span>' + text + '</span></li>';

                }
                langArray.push(item);
            })

            $('#a').html(langArray);
            //Set the button value to the first el of the array
            $('.btn-select').html(langArray[0]);
            $('.btn-select').attr('value', '');
            //change button stuff on click
            $('#a li').click(function () {
                var img = $(this).find('img').attr("src");
                var value = $(this).find('img').attr('value');
                var text = this.innerText;
                var dis = this.innerText;
                if (dis == "Select Country") {
                    var item = '<li><span>' + text + '</span></li>';
                    $('.btn-select').attr('value', "");
                } else {
                    var item = '<li><img src="' + img + '" alt="" /><span>' + text + '</span></li>';
                    $('.btn-select').attr('value', value);
                }
                $('.btn-select').html(item);
                $("#country").prop("selectedIndex", text);
                $(".b").toggle();
                //console.log(value);
            });
            $(".btn-select").click(function () {
                $(".b").toggle();
            });
            //check local storage for the lang
            var sessionLang = localStorage.getItem('lang');
            if (sessionLang) {
                //find an item with value of sessionLang
                var langIndex = langArray.indexOf(sessionLang);
                $('.btn-select').html(langArray[langIndex]);
                $('.btn-select').attr('value', sessionLang);
            } else {
                var langIndex = langArray.indexOf('ch');
                console.log(langIndex);
                $('.btn-select').html(langArray[langIndex]);
                //$('.btn-select').attr('value', 'en');
            }



        </script> -->
    </body>
</html>