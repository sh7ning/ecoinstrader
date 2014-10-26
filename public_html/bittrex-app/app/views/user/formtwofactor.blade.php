<!-- Security -->
@section('title')
{{{ trans('user_texts.security') }}}
@stop
<div id="security">
    <h2>{{{ trans('user_texts.security')}}}</h2>
    @if(empty(Auth::user()->authy))
    <h3><img src="{{asset('assets/img/authy_icon.png')}}"> {{{ trans("user_texts.two_factor_auth")}}}: <span id="twofaStatus">{{{trans('user_texts.disable')}}}</span></h3>
    <!-- <button type="submit" id="install-two-auth" class="btn btn-primary">{{{ trans('user_texts.install')}}}</button> -->
    <!-- Modals -->
	<div id="messageModal" class="modal">
		<div class="modal-dialog">
		    <div class="modal-content">      
		      <div class="modal-body"> 
		      	<form class="form-horizontal" role="form">
					<div class="control-group">
				      <label class="control-label" for="inputEmail">{{{ trans('user_texts.code_country')}}}</label>
				      <div class="controls">  
				      	<input id="authy-countries" name="country-code" required>
				      </div>
				    </div>
				    <div class="control-group">
				      <label class="control-label" for="inputPassword">{{{ trans('user_texts.phone_number')}}}</label>
				      <div class="controls">      
				        <input id="phone" name="phone" type="text" maxlength="10"> 
				      </div>
				    </div>
				    <br>
				    <div class="control-group notice marker-on-top bg-darkRed fg-white" id="mesage-errors" style="display:none">
				    </div>
				</form>       
		      </div>
		      <br>
		      <div class="modal-footer">		      	
		      	<button type="submit" id="post-two-auth" class="btn btn-primary">{{{ trans('user_texts.submit')}}}</button>
		        <button type="button" class="btn btn-default" data-dismiss="modal">{{{ trans('user_texts.close')}}}</button>
		      </div>
		    </div>
		  </div>		  
	</div>
    <script type="text/javascript">	
		$(function(){  
			$('#install-two-auth').click(function(e) {
		      	//$('#messageModal').modal({show:true});
		    });
		    $('#post-two-auth').click(function(e) {
		    	var phone = $('#phone').val();
		    	var code_area = $('input[name=country-code]').val();
		      	$.post('<?php echo action('AuthController@ajaxRequestInstallation')?>', {isAjax: 1, phone:phone, code_area:code_area}, function(response){
		      		console.log('response: ',response);
			        var obj = $.parseJSON(response);
			        if(obj.status=='error'){
			        	var errors = obj.errors;
			        	var html = '<p>'+errors.message+'</p><p>'+errors.country_code+'</p><p>'+errors.cellphone+'</p>';
			        	$('#mesage-errors').html(html).show();
			        }else{
			        	location.reload();
			        }
			        
			    });
		    });	
	    
		});
		</script>
    @else
    <h3>{{{ trans("user_texts.two_factor_auth")}}}: <span id="twofaStatus">{{{trans('user_texts.enable')}}}</span></h3>
    <button type="submit" id="uninstall-two-auth" class="btn btn-primary">{{{ trans('user_texts.uninstall')}}}</button>
    <script type="text/javascript">	
		$(function(){ 
		    $('#uninstall-two-auth').click(function(e) {    	
		      	$.post('<?php echo action('AuthController@ajaxUninstallation')?>', {isAjax: 1}, function(response){
		      		console.log('response: ',response);
			        var obj = $.parseJSON(response);
			        if(obj.status=='error'){
			        	var errors = obj.errors;
			        	var html = '<p>'+errors.message+'</p><p>'+errors.country_code+'</p><p>'+errors.cellphone+'</p>';
			        	$('#mesage-errors').html(html);
			        }else{
			        	location.reload();
			        }
			        
			    });
		    });
		});
		</script>
    @endif
</div>
{{HTML::style('assets/css/flags.authy.css')}}
{{HTML::style('assets/css/form.authy.css')}}
{{ HTML::script('assets/js/form.authy.js') }}