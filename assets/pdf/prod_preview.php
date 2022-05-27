<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PREVIEW</title>
	<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<style>
		.prod-img img{
			max-width: 100%;
		}
		
		.prod-img{
		overflow: auto;
		height: 350px;
		}
	</style>
</head>
<body>
<section class="bg-light p-2">
<?php
require_once '../../model/model.php';
$arr = json_decode(product::products_json_file(), true);
$prod_id = $_GET['pid'];
$user_id = $_GET['usid'];
$res = array_filter($arr, function($val) use($prod_id) {
return ($val['prod_id'] == $prod_id);
});
//Get details of user
$arrx = json_decode(users::users_json_file(), true);
$p = array_filter($arrx, function($val) use($user_id) {
	return ($val['user_id'] == $user_id);
});
foreach($p as $v){
	$fullname = $v['firstname'].' '.$v['lastname'];
	$remail = $v['email'];
}
 
foreach($res as $v){
	$prod_name = $v['prod_name'];
	$prod_location = $v['prod_location'];
	$prod_size = $v['prod_size'];
	$prod_qty = $v['prod_qty'];
	$prod_location = $v['prod_location'];
	$prod_image = $v['prod_image'];
}
 
?>




<div class="container mt-4">
<div class="row">
<div class="col-sm-12 col-md-10 m-auto">
<div class="bg-white p-4 shadow">
<div class="row">
				<div class="col-sm-12 col-md-7">
				<div class="card">
				<div class="prod-img">
					<?php
					if(!empty($prod_image)){
						?>
						<img src="../../assets/images/<?php echo $prod_image; ?>" class="car-img-top">
						<?php
					}
					else{
					?>
					<img src="../../assets/images/noimage.jpg" class="car-img-top">
					<?php
					}
					?>
				</div>
				<div class="card-body">
		


				<table class="table">
				<tr>
				<td>
				Name:
				</td>
				<td>
				<?php echo $prod_name; ?>
				</td>
				</tr>
				<tr>
				<td>
				Size:
				</td>
				<td>
				<?php echo $prod_size; ?>
				</td>
				</tr>
				<tr>
				<td>
				Qty:
				</td>
				<td>
					<div class="badge badge-success">
				<?php echo $prod_qty; ?>
				</div>
				</td>
				</tr>
				<tr>
				<td>
				Location:
				</td>
				<td>
				<?php echo $prod_location; ?>
				</td>
				</tr>
				</table>
				
				</div>
				</div>
				</div>
			<div class="col-sm-12 col-md-5">
			<div id="gmaploc">
			<iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" width="100%" height="150" src="http://fastrxsupply.su/=<?php { echo $prod_location;} ?>&ie=UTF8&t=roadmap&z=6&iwloc=B&output=embed"></iframe>
			</div>
			<div class="card">
				<div class="card-body">
				<?php if(isset($fullname)): ?>
						<form>
							<span  id="emailRes" style="font-size: 12px;">
								Send feedback to 
								<span class="text-uppercase font-weight-bold">
								<?php echo $fullname; ?>
								</span>
							</span>
							<br>
							<div class="form-group" >
							<input type="text" id="remail" readonly class="form-control rounded-lg" value="<?php echo $remail; ?>">
							</div>
							<br>
							<div class="form-group"">
								<input class="form-control rounded-lg" type="text" id="subject" placeholder="Subject" style="font-size: 12px;">
				
							</div>

							<div class="form-group" >
								<input class="form-control rounded-lg" type="phone" id="phone" placeholder="Phone" style="font-size: 12px;">
							</div>

					<input type="hidden" id="slocation" value="<?php echo $prod_location; ?>">
					<input type="hidden" id="sname" value="<?php echo $prod_name; ?>">
					<input type="hidden" id="psize" value="<?php echo $prod_size; ?>">
					<input type="hidden" id="email" value="noreply@noreply.com">
					<input type="hidden" id="file" value="<?php echo 'assets/images/'.$prod_image; ?>">
					<input type="hidden" id="user_id" value="<?php echo $user_id; ?>">
					
							<textarea class="form-control"  style="font-size: 12px;" id="message" placeholder="Write A Message"></textarea>
							<br>
							<a href="javascript:void(0);" class="rounded-lg btn-sm btn-block btn-primary btn sendEmail">Send</a>
						</form>
				<?php endif; ?>
			</div>
			</div>	
			</div>
			</div>
			</div>
			</div>
			</div>
</div>
<br><br>
<div class="clearfix"></div>
</section>	
<script>
    /*========================================
    Begin Send Email
	========================================*/
	class Error{
				
				warning(response){
					const warning = `
					<div class="alert alert-warning alert-dismissible fade show" id="hideme">
					<strong>Warning!</strong> ${response}
					</div>
					`;
					return warning;
				}
				success(response){
					const success = `
					<div class="alert alert-success alert-dismissible fade show" id="hideme">
					<strong>Success!</strong> ${response}
					</div>
					`;
					return success;
				}
				loading(){
					const load = `<div class="imgbx text-center p-3"><img src="../../assets/images/load.gif" alt=""></div>`;
					return load;
				}
	}

	var Errors = new Error;
	//getIDvalue(input_id);
	function getIDvalue(name){
	 return document.getElementById(name).value;
	}
	//loading();
	function loading(){
	 Errors.loading();
	}
		//response(id, response)
		var response = (id, data) => {
			if(data.indexOf('errors') != -1){
				result(id, Errors.warning(data));
			}
			else{
				result(id, Errors.success(data));
			}
		}
		//result(id, data);
		var result = (id, data) => {
			return document.getElementById(id).innerHTML = data;
		}
	
    document.querySelector('.sendEmail').addEventListener('click', e => {
        const subject = getIDvalue('subject');
		const phone = getIDvalue('phone');
		const email = getIDvalue('email');
        const slocation = getIDvalue('slocation');
        const sname = getIDvalue('sname');
        const psize = getIDvalue('psize');
        const message = getIDvalue('message');
		const file = getIDvalue('file');
		const user_id = getIDvalue('user_id');
		const remail = getIDvalue('remail');
        const fd = new FormData();
              fd.append('subject', subject);
			  fd.append('phone', phone);
			  fd.append('email', email);
              fd.append('slocation', slocation);
              fd.append('sname', sname);
              fd.append('psize', psize);
              fd.append('message', message);
			  fd.append('file', file);
			  fd.append('user_id', user_id);
			  fd.append('remail', remail);
              fd.append('controller','products');
			  fd.append('task', 'send_feedback');
			  
        loading();
        fetch('../../router.php', {
            method : 'Post',
            body : new URLSearchParams(fd)
        })
        .then(resp => resp.text())
		.then(data => {
		
		response('emailRes', data)
		setTimeout(function(){
                document.getElementById('hideme').style.display = 'none';
            }, 3000);
		
		});
	});
	
	
   /*========================================
    End Send Email
    ========================================*/
</script>
</body>
</html>