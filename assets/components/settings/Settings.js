
import { textInput,textArea,Button,Titlebar } from '../utils/InputFields.js'

const page = ()=>{

return `
<div class="container">
<div class="row">
    <div class="col-sm-12 col-md-10 m-auto">
        <div class="bg-white settings-inner">

        <div class="row">
            <div class="col-sm-12">
                <div class="settings-header">

                <img src="assets/images/cover.png" alt="Header Image" />

                <div class="settings-logo">
                  <img src="" alt="Header Image" />
                </div>

                <h1 class="comp-title">COMPANY NAME</h1>

                </div>
            </div>
        </div>



        ${Titlebar('BUSINESS DETAILS')}
            <div class="row">
            <div class="col-md-6 col-sm-12">
                ${
                    textInput({
                        type: 'text',
                        classname: '',
                        required: true,
                        label: 'Business Name'
                    })

                }
                ${
                    textInput({
                        type: 'text',
                        classname: '',
                        required: true,
                        label: 'Business Phone'
                    })

                }
                ${
                    textInput({
                        type: 'text',
                        classname: '',
                        required: true,
                        label: 'Business Address'
                    })

                }
                ${
                    textInput({
                        type: 'text',
                        classname: '',
                        required: true,
                        label: 'Business Location'
                    })

                }
            </div>
            <div class="col-md-6 col-sm-12">
                ${
                    textInput({
                        type: 'email',
                        classname: '',
                        required: true,
                        label: 'Business Email'
                    })

                }
                ${
                    textInput({
                        type: 'text',
                        classname: '',
                        required: true,
                        label: 'Bank Name'
                    })

                }
                ${
                    textInput({
                        type: 'text',
                        classname: '',
                        required: true,
                        label: 'Bank ACC name'
                    })

                }
                ${
                    textInput({
                        type: 'text',
                        classname: '',
                        required: true,
                        label: 'Bank Branch'
                    })

                }
            </div>
            </div>



            ${Titlebar('SMS DETAILS')}
            <div class="row">
            <div class="col-md-6 col-sm-12">
                ${
                    textInput({
                        type: 'text',
                        classname: '',
                        required: true,
                        label: 'Business Name'
                    })

                }
                ${
                    textInput({
                        type: 'text',
                        classname: '',
                        required: true,
                        label: 'Business Phone'
                    })

                }
                </div>








        </div>
    </div>
</div>
</div>
`


}

document.querySelector('.root').innerHTML = page()