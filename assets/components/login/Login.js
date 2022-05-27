
import { textInput,Button } from "../utils/InputFields.js"


const Login = ()=>{

    return `
        <div class="login-wrapper">

                <div class="login-inner">

                    <form autocomplet="off">

                        <div class="comp_name">
                        <h4>COMPANY NAME</h4>
                        <p>Sign in with your valid username and password</p>
                        </div>

                        ${
                            textInput({
                            		type: 'text',
                            		classname: 'username lgn',
                            		required: true,
                            		label: 'Username'
                            	})
                        }
          
                        ${
                            textInput({
                            		type: 'password',
                            		classname: 'password lgn',
                            		required: true,
                            		label: 'Password'
                            	})
                        }
       
                        <a href="forgotpassword.html">Reset Password?</a>

                        ${
                            Button({
                                output: 'output1',
                                classname: 'login-btn',
                                buttonname: 'LOG IN'
                            })
                        }
                    

                    </form>
            </div>
    </div>

    `
}

document.querySelector('.root').innerHTML = Login()