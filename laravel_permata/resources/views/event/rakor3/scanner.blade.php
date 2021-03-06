@extends('frontend.layout')

@section('header-css')
<link rel="stylesheet" href="{{url('/')}}/landing/main.css" />
<link rel="stylesheet" href="{{url('/')}}/landing/login.css" />
@endsection

@section('header-js')
@endsection

@section('content')

    <!-- Page Wrapper -->
      <div id="page-wrapper">
              <section id="profile" class="wrapper alt spotlight style2">
                <div class="w-100 text-center">
                    <img height="50px" src="{{url('/')}}/img/logo_permata.png">
                </div>
                <div class="inner">
                  <div class="content">
                    <label class="content-header text-center">SCAN QR CODE</label>
                    <div class="w-100 text-left" style="font-size: 0.7em">bila <b>scanner tidak dapat digunakan</b>, harap menggunakan aplikasi QR scanner pihak ke-3</div>
                    <div class="row">
                       <canvas style="margin:auto !important;"></canvas>
                       <hr>
                      <select></select>
                  </div>
                  <span id="scan-result"></span>
              </section>

      </div>

    <!-- Scripts -->

@endsection
  
@section('footer-js')  
<script src="{{url('/')}}/assets/template/solid-state/assets/js/main.js"></script>
<script src="{{url('/')}}/vendor/WebCodeCam.js"></script>
<script src="{{url('/')}}/vendor/qrcodelib.js"></script>
<script type="text/javascript">
  $("#scan-result").html('test');
  var txt = "innerText" in HTMLElement.prototype ? "innerText" : "textContent";
  var arg = {
      resultFunction: function(result) {
        $("#scan-result").html(result.code);
        window.location.href = result.code;
      }
  };
  var decoder = new WebCodeCamJS("canvas").buildSelectMenu('select', 'environment|back').init(arg).play();
  document.querySelector('select').addEventListener('change', function(){
    decoder.stop().play();
  });
</script>
@endsection