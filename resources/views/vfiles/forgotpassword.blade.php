

<style type="text/css">
  .login-box, .register-box {
    width: 420px;
}

.error-message {
    color: #ff0000;
  }
</style>
<div class="login-box">
   
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
         <div class="login-logo text-left">
          <a href="{{url('/')}}">
           <img src="@asset("img/adminlogo.png")" alt="" style="width:80%" class="img-fluid">
          </a>
      </div>
    
        <p class="login-box-msg text-center">Reset Your Password</p>  
           
        @error('pass')
            <p class="help-block">{{$message}}</p>
        @enderror

      <form  id="forgotpasswordform" method="POST">
         @csrf
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="User Name" required maxlength="100" name="user_name">
             <span class="error"></span>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Mobile Number" required maxlength="10" name="mobile_number" minlength="10">
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

            <!-- /.col -->
            <div class="col-4">
              <button type="button" id="submit_forgotform" onclick="submit_forgotform();" class="btn btn-primary btn-block">Submit</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  
  <script src="@asset("plugins/jquery/jquery.js")"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  
  <script>
  
  $(function () {
    
    $("#submit_forgotform").click(function() {
       var formData = new FormData($('#forgotpasswordform')[0]);
       //formData.append( "_token", "{{csrf_token()}}" ); 
       $('.error').html('');
       $('.error-message').html('');
       
       $.ajax({
            url : "<?php echo URL::to('/');?>/reset-password",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function (data)
            {
             /* if (data.status) {
                swal({
                      title: "Password has been reset successfully!",
                      text: "You will recieve password in SMS!",
                      icon: "success",
                    });
                window.location.href = data.redirect_url;
              }
              else{
                //  swal(data.message);

                  reload_captcha();
				          $('.error-message').html(data.message);
                  $('#submit_forgotform').removeAttr('disabled').text('Sign In');
              }
                 swal(data.message);
              }*/

              /* if (data.status) {
                    //toastr.success(data.message)
                    swal({
                        title: "Password has been reset successfully!",
                      text: "You will recieve password in SMS!",
                      icon: "success"
                    }, function(isConfirm) {
                        if (isConfirm) {
                            window.location.href = data.redirect_url;
                        }
                    });
                }*/

                  if (data.status) {        
                //toastr.success(data.message);
                swal("Password has been reset successfully!",'You will recieve password in SMS!', "success"); 
                setTimeout(function(){
                  window.location.href = data.redirect_url;
                    }, 3000);
            } else {
                 reload_captcha();
             $('.error-message').html(data.message);
            }

          
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                 $.each(jqXHR.responseJSON.errors, function (key, value) {
            
                       $('#forgotpasswordform [name="' + key + '"]').next().html(value);
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
</style>
