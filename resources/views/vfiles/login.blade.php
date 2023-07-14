

<style type="text/css">
  .login-box, .register-box {
    width: 420px;
}
</style>
    
<div class="login-box" style="margin-top:10px;">
   
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
     
        <div class="login-logo ">
        <a href="{{url('/')}}">
        <img src="@asset("img/adminlogo.png")" alt="" style="width:80%" class="img-fluid">
        </a>
      </div>
		
        <p class="login-box-msg text-center">		
		Sign in to start your session</p>
        @error('pass')
            <p class="help-block">{{$message}}</p>
        @enderror
        <form  id="loginform" action="#" method="post" autocomplete="off" >
            @csrf
            {{-- start --}}
          <div class="input-group mb-3">
            <select name="eFisher_pmmsy_url" id="eFisher_pmmsy_url" class="form-control" onchange="redirect_efisher_pmmsy(this.value)">
              <option value="eFisher">Ematsyakar</option>
              <option value="pmmsy">PMMSY</option>
              <option value="kcc">KCC</option>
              <option value="domestic_market">Domestic Mktg</option>
            </select>
          </div>
          {{-- end --}}

          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="UserName" required maxlength="100" name="user_name" autocomplete="off" >
			      <span class="error"></span>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" required maxlength="100" name="password" autocomplete="off">
			<span class="error"></span>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
		  <div class="form-group row">
                                <div class="col-md-12">
                                    <span class="error-message"></span>
                                </div>
          </div>
            <!--captcha start-->
           {{-- <div class="form-group mt-4 mb-4">
                <div class="captcha">
                    <span>{!! captcha_img() !!}</span>
                    <button type="button" class="btn btn-danger" class="reload" id="reload">
                        &#x21bb;
                    </button>
                </div>
            </div>
            <div class="form-group mb-4">
                <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha" autocomplete="off">
            </div> --}}

            <div class="row mb-4" style="padding-left:15px">
            <div class="form-group mb-2">
              <div class="captcha">
                  <span>{!! captcha_img() !!}</span>
                  <button type="button" class="btn btn-danger" class="reload" id="reload">
                      &#x21bb;
                  </button>
              </div>
          </div><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
          <div class="input-group-append mb-2">
              <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha" autocomplete="off">
          </div>
          </div>
            <!--captcha end-->
							
          <div class="row">
            
            <!-- /.col -->
            <div class="input-group mb-3">
              <button type="button" id="submitform" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mt-1">
          {{-- <a href="#" class="btn btn-link" title="Click here to reset your password">
            Forgot Your Password?
        </a> --}}
		 
        </p>
        @if(env('APP_ENV')!="local")
        <p class="mt-1">
         <a href="{{ url('/forgot-password') }}" class="btn btn-link" title="Click here to reset your password">
            Forgot Your Password?
        </a>
        </p>
        @endif


        
         

        <hr>

        <div class="row">

          <div class="col-8">
           <a href="{{ url('/user/sign_up') }}" class="btn btn-link" title="Click here to reset your password">
           Create an User Account?   </a>
          </div>

           <div class="col-4">    
            <a href="{{URL::to('/user/sign_up')}}" target="_blank" class="btn btn-success btn-block" type="button">Sign Up</a>
          </div>

          </div>



       
       
 
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <style>

  .swal2-close{
    background-color: red;
  }

  </style>
  
  <script src="@asset("plugins/jquery/jquery.js")" ></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	
  <script>
  // $(document).ready(function () {

  //   Swal.fire({
  //     imageUrl: '{{ asset("/images/azadi.jpg")}}',
  //     width: '70%',
  //     height: '30%',
  //     showCloseButton: true,
  //     showCancelButton: false,
  //     showConfirmButton: false,
  //   });

  // });

    //start
    // $(document).ready(function(){
    //   val = $("#eFisher_pmmsy_url").val();
    //   redirect_efisher_pmmsy(val);
    // });
    // end
	
  $(function () {
    
	
	
	$("#submitform").click(function() {
		
   var formData = new FormData($('#loginform')[0]);
 
   formData.append( "_token", "{{csrf_token()}}" ); 
   
   $('.error').html('');
   $('.error-message').html('');
   $('#submitform').attr('disabled','disabled').text('Logging..');
   $.ajax({
        url: '{{ url('admin/dologin') }}',
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",
        async: false,
        success: function (data)
        {
		
			var APP_URL = {!! json_encode(url('/')) !!};
			
			if (data.status) {
				
				window.location.replace(APP_URL+data.redirect);
				
            }else{
              reload_captcha();
				$('.error-message').html(data.message);
        $('#submitform').removeAttr('disabled').text('Sign In');
			}
			
	
			
		    },
        error: function (jqXHR, textStatus, errorThrown)
        {
          $('#submitform').removeAttr('disabled').text('Sign In');
             $.each(jqXHR.responseJSON.errors, function (key, value) {
                    
				
                   $('#loginform [name="' + key + '"]').next().html(value);
				   
				   //.parent().addClass('has-error');;
						
             });
             reload_captcha();
			 $('.error-message').html('Entered Wrong Captcha');
        }
		
   });
		
		
		});

   $('#reload').click(function () {
        reload_captcha();
    });

		
  });

  function reload_captcha(){
      $.ajax({
            type: 'GET',
            url: '{{ url("admin/reload-captcha") }}',
            success: function (data) {
                $(".captcha span").html(data.captcha);
            }
        });
    }

    function redirect_efisher_pmmsy(val){
      if(val != '' && val =='eFisher'){
        window.location ="{{ URL::to('https://ematsyakar.com/efisher/') }}";
      }else if(val != '' && val =='pmmsy'){
        window.location ="{{ URL::to('https://ematsyakar.com/pmmsy/') }}";
      }else if(val != '' && val == 'domestic_market'){
        window.location ="{{ URL::to('https://ematsyakar.com/retailunits/') }}";
      }else{
        window.location ="{{ URL::to('https://ematsyakar.com/kcc/') }}";
      }
    }
</script>

<style>
.error{
	
	font-size:12px;
}
.login-card-body .input-group 
{
  position: relative;
}
.login-card-body .input-group .error
{
  position: absolute;
  bottom: -18px;
  color: #ff0000;
}
.error-message
{
    color: #ff0000;
}
 
</style>
