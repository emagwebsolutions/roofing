import Lists from "../utils/Lists.js"
import searchBox from "../utils/searchBox.js"
import Sidebar from "../utils/Sidebar.js"
import getUsers from "../utils/getUsers.js"
import DetailsBox from "../utils/DetailsBox.js"
import { classSelector } from "../utils/Selectors.js"
import { formatDate } from "../utils/DateFormats.js"
import Buttons from '../utils/Buttons.js'
import Modalbox from '../widgets/Modalbox.js'
import Spinner from '../utils/Spinner.js'
import Error from '../utils/Error.js'
import Success from '../utils/Success.js'
import { textInput,checkBox } from '../utils/inputFields.js'
import Title from '../utils/Title.js'


getUsers()
const obj = JSON.parse(localStorage.getItem('usersDetails'))[0].users_details

const userdetails = ( v ) => {
    const date = v?.hire_date? formatDate(v?.hire_date)  : ''
    return  `<ul>
    <li> 
        <ul>
            <li><i class="fa fa-user text-muted"></i> Fullname:</li> 
            <li>${v?.firstname || ''} ${v?.lastname || ''}</li>
        </ul>
    </li>

    <li> 
        <ul>
            <li><i class="fa fa-calendar text-muted"></i> Hire Date:</li> 
            <li>${date}</li>
        </ul>
    </li>

    <li> 
        <ul>
            <li><i class="fa fa-home text-muted"></i> Residence:</li> 
            <li>${v?.location || ''}</li>
        </ul>
    </li>

    <li> 
        <ul>
            <li><i class="fa fa-phone text-muted"></i> Phone:</li> 
            <li>${v?.phone || ''}</li>
        </ul>
    </li>

</ul>`
}

document.addEventListener('click', e => {

    if(e.target.matches('.addUserModalClass')){
        Spinner('addUserModalClass')

        Error('addUserModalClass','This is an error message')

        Success('addUserModalClass','This is a success message')
    }

    if(e.target.matches('.ufname')){
        const { id } = e.target.dataset

        const getSingleUserdetails = obj.filter( v => v.user_id === id ).map( v => (userdetails(v))).join('')

        classSelector('col1').innerHTML = getSingleUserdetails
    }

    if(e.target.matches('.addUser')){
        document.body.style.overflow = 'hidden'
        classSelector('modal-wrapper').classList.add('show')
    }

})

window.addEventListener('load', e => {
    classSelector('col1').innerHTML = userdetails()
    classSelector('hiredate').valueAsDate = new Date()
})


const addUserForm = () => (
    `    
    ${Title('New User Details')}
    <div class="usersDetails">
        <div>
		 ${
            textInput({
                type: 'text',
                classname: 'firstname',
                required: true,
                label: 'First Name'
            })
         }
         ${
            textInput({
                type: 'text',
                classname: 'lastname',
                required: true,
                label: 'Last Name'
            })
         }
         ${
            textInput({
                type: 'text',
                classname: 'phone',
                required: true,
                label: 'Phone'
            })
         }
         ${
            textInput({
                type: 'text',
                classname: 'residence',
                required: true,
                label: 'Residence'
            })
         }

         ${
            textInput({
                type: 'email',
                classname: 'email',
                required: true,
                label: 'Email'
            })
         }
        </div>
        <div>

        ${
            textInput({
                type: 'date',
                classname: 'hiredate',
                required: true,
                label: 'Hire Date'
            })
         }

         ${
            textInput({
                type: 'date',
                classname: 'birthdate',
                required: true,
                label: 'Birthdate'
            })
         }
  
         ${
            textInput({
                type: 'text',
                classname: 'username',
                required: true,
                label: 'Username'
            })
         }
         ${
            textInput({
                type: 'text',
                classname: 'password',
                required: true,
                label: 'Password'
            })
         }
         ${
            textInput({
                type: 'text',
                classname: 'repassword',
                required: true,
                label: 'Re-Password'
            })
         }
        </div>
    </div>

    ${Title('New User Previlleges')}

    <div class="addUserPrevileges">

    <div> 
        ${checkBox('salesinvoice','Sales Invoice')}
        ${checkBox('salesinvoice','Proforma Invoice')}
        ${checkBox('salesinvoice','Products')}
    </div>
    <div> 
        ${checkBox('salesinvoice','SMS')}
        ${checkBox('salesinvoice','Leads')}
        ${checkBox('salesinvoice','Opportunity')}
    </div>

    </div>
    
    `
)
    

const Employees = () => {

    const arr = obj.map( v => {
        return Lists({
            editclass: 'edituser',
            deltclass: 'deltuser',
            fnameclass: 'ufname',
            name: v.firstname+' '+v.lastname,
            id: v.user_id,
            role_id: v.role_id || 0
        })
    }).join('')


        return `
        <div class="container mb-2">
        <div class="row gap-3">

            <div class="sidebar bg-white">

                ${Sidebar(searchBox('search-users','Search users'),arr)}

            </div>

            <div class="cont">
                ${Buttons([
                    {
                        btnclass: 'addUser',
                        btnname: 'Add User'
                    }
                ])}
                ${ DetailsBox('col1','col2') }
            </div>

        </div>
        </div>

        ${Modalbox('ADD USER','addUserModalClass', addUserForm())}
        `

}

document.querySelector('.root').innerHTML = Employees()

