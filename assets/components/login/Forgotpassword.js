const Forgotpassword = ()=>{
        return `
            <div style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.5))">

            <!-- login area start -->
            <div class="login-area login-s2">
                <div class="container">
                    <div class="login-box ptb--100">
                <form action="router.php" method="post"  id="lostpwd" onsubmit="parent.scrollTo(0, 0);   return false">

                            <div class="login-form-head animated fadeInDown" data-animation="fadeInDown">
                                <h4 class="text-warning" id="comp_name"></h4>
                                <p  class="text-white">Password Reset</p>
                            </div>

                            <div class="text-center text-white">					
                                <div class="result error color-white"></div>
                            </div>	
                            
                            <div class="login-form-body animated fadeInUp" data-animation="fadeInUp">

                            <div class="form-group inputBox2">
                                <input type="text"  id="username" required class="form-control text-white bg-transparent" >
                                <label class="text-warning">Enter username or email</label>
                                </div>  

                                <div class="row mb-4 rmber-area">
                                    <div class="col-6">
                                    </div>
                                    <div class="col-6 text-right">
                                    <a href="index.php" style="font-size: 12px; color: #fff;">Log in</a><br>
                                    </div>
                                </div>

                            <div class="submit-btn-area">
                            <input type="hidden" id="task" value="lostpwd">
                            <a href="javascript:void(0);" id="form_submit" class="d-block fsm">
                            Get New Password
                            </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <!-- login area end -->
            </div>
        `

}


document.querySelector('.root').innerHTML = Forgotpassword()