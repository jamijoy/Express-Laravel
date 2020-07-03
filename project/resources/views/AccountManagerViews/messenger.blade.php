<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="csrf-token" content="{{csrf_token()}}">
        <title>Account Manager - Messenger</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/generalCSS/login.css') }}">
		<script src="{{asset('js/jquery-3.4.1.js')}}"></script>
		<script src="{{asset('js/myScript.js')}}"></script>
    </head>
    <body>
        <!-- navbar section start -->
        <section class="navbar">
            <div class="container">
                <nav class="navbar navbar-expand-lg">
                    <a class="navbar-brand brand-link" href="/">Express</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon">Menu</span>
                    </button>
                  
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link about-link" href="#"></a>
                            </li>
							<li class="nav-item about-link">
								<select class="form-control select-bar" id="profileBtn" onchange="myFunc()">
									<option value="" disabled="true" selected>{{$user->first_name}} {{$user->last_name}}</option>
									<option value="/AccountManager/Profile">Profile</option>
									<option value="/AccountManager/Timeline">Timeline</option>
									<option value="/logout">Logout</option>
								</select>
                            </li>
							<li class="nav-item">
                                <a class="nav-link about-link" href="/AccountManager/Report/General">Account Report</a>
                            </li>
							<li class="nav-item">
                                <a class="nav-link about-link" href="/AccountManager/StatisticalReport/General">Statistical Report</a>
                            </li>
							<li class="nav-item">
                                <a class="nav-link about-link" href="/AccountManager/UserPosts/05">User Post</a>
                            </li>
							<li class="nav-item">
                                <a class="nav-link about-link" href="#msgModal" data-toggle="modal"> &#128226 ({{count($msgData)}}) </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </section>
        <!-- navbar section end -->
			
            <div class="row">
				<div style="margin-left:50px;">
                    @foreach($msgData as $msgs)
					 @if($msgs->sender_id == session()->get('user_id')) @php( $recipient=$msgs->receiver_id ) @else @php( $recipient=$msgs->sender_id ) @endif
					  <a href="#msgModal" data-toggle="modal" class="dropdownie" id="{{$recipient}}">
					   <div class="notify-icon"> </div>
						<p class="notify-details">{{$recipient}}</p>
						 <p class="text-muted font-13 mb-0 user-msg">{{$msgs->message_text}}</p>
						  </a><!--/ dropdown-item-->
						   @endforeach
				</div>
            </div>
		
		<div id="msgModal" class="modal fade">
		  <div class="modal-dialog">
		   <div class="modal-content">
			<div class="modal-header">
				<h3>Notifications</h3>
				<p class="right-align"><a href="#myModal" data-dismiss="modal">&#10008 </a></p>
			</div>
			<div class="modal-body">
				<div class="post-area">
					@foreach($msgData as $dtt)
						<div class="notif-div">
							<p class="sender-tag">{{$dtt->first_name}} {{$dtt->last_name}} <a class="del-color" href="/deleteMessage/{{$dtt->message_id}}">&#9746 </a><br/>
								<span class="muted-text" style="color:black;">{{$dtt->message_time}}</span></p>
									&nbsp {{$dtt->message_text}}
										</div>
					@endforeach
				</div>
				<form action="/AccountManager/MessagePost" method="Post"> {{csrf_field()}} 
					<div class="form-group">
						<br/>@foreach($errors->all() as $err)
								{{$err}} <br>
							@endforeach
							<input type="text" class="form-control" id="msg" placeholder="Write Your Message Here ..." name="msg">
							</div></form>
				
			</div><!--/ modal-body -->
		   </div><!--/ modal-content -->
		  </div><!--/ modal-dialog -->
		 </div><!--/ modal -->
		<!-- CDN link section start -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <!-- CDN link section end -->
		
		<script>  
			$(document).ready(function(){  
				// $('.dropdown-item').on("click",function(){

					// var msg_id = $(this).attr("id");
					// console.log('Its Message Modal');
					// console.log(msg_id +" .............................................");
					
					// $.ajax({  
					   // type:'POST',
					   // url:"{{route('UserPost.message')}}",
					   // data:{
						   // _token : $('meta[name="csrf-token"]').attr('content'),
						   // id : msg_id
					   // },
					   // success:function(data) {
						  // alert("Success");
						 // $('#messageTxt').html(data.msData);
						 // $('#msgModal').modal("show");
					   // }
					// });
				// });
				
				$('.view_details').on("click",function(){

					$.ajaxSetup({
						headers:{
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});  
					console.log("we are in modal");  
					var post_id = $(this).attr("id");
					console.log(post_id);
					$.ajax({  
						url:"{{route('post.ajaxPost')}}",  
						method:"post",  
						data:{ post_id:post_id},  
						success:function(data){  

							 $('#hidden_post_id').attr('value', data.post_data.post_id);
							 $('#post_image').attr('data', '../storage/'+data.post_data.post_image);
							 $('#alt_image').attr('alt', data.post_data.post_text);
							 $('#post_text').html(data.post_data.post_text);
							 $('#comment_div').html(data.comment_data);

							 console.log(data);

							 $('#myModal').modal("show");  
						}  
					});  
				});
				
				$('.dropdownie').on("click",function(){

					$.ajaxSetup({
						headers:{
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});  
					console.log("in modal msg Modallll .....................");  
					var msg_id = $(this).attr("id");
					console.log(msg_id+" ..........................");
					$.ajax({  
						url:"{{route('Messenger.Messenger')}}",  
						method:"get",  
						data:{ id:msg_id},  
						success:function(data){  

							 alert("Success");
						}  
					});  
				});

				$('.like_btn').on("click",function(e){

					e.preventDefault();
					$.ajaxSetup({
						headers:{
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});  
					console.log("we are in like");  
					var post_id = $(this).attr("id");
					console.log(post_id);
					$.ajax({  
						url:"{{route('post.ajaxLike')}}",
						method:"post",  
						data:{ post_id:post_id},
						success:function(data){

							//$('#abc').html(data.likes);  
							$('.like_btn').html(data.likes);

							 console.log(data.likes);

							 // $('#myModal').modal("show");
						}  
					});  
				});
				
			});  
		</script>
    </body>
</html>