import Lists from "../utils/Lists.js"
import searchBox from "../utils/searchBox.js"
import Sidebar from "../utils/Sidebar.js"
import getUsers from "../utils/getUsers.js"
import DetailsBox from "../utils/DetailsBox.js"
import { classSelector,classValueSelector } from "../utils/Selectors.js"
import { formatDate } from "../utils/DateFormats.js"
import Buttons from '../utils/Buttons.js'
import Modalbox from '../widgets/Modalbox.js'
import Spinner from '../utils/Spinner.js'
import Error from '../utils/Error.js'
import Success from '../utils/Success.js'
import { textInput,checkBox } from '../utils/inputFields.js'
import Title from '../utils/Title.js'

// This function displays list of users
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
            <li>${v?.residence || ''}</li>
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



//Start click events 
document.addEventListener('click', e => {

    if(e.target.matches('.edit-record')) {

        document.body.style.overflow = 'hidden'
        classSelector('modal-wrapper').classList.add('show')

        getUsers((data) => {
            const { id } = e.target.dataset

            console.log(data)

            const obj = Object.values(data).map( v => v.users.map(v => ({
                user_id: v.user_id,
                firstname: v.firstname,
                lastname: v.lastname,
                phone: v.phone,
                residence: v.residence,
                birthdate: v.birthdate,
                username: v.username,
                hire_date: v.hire_date,
                email: v.email
            }))).flat(Infinity)

            const v = obj.filter( v => v.user_id === id )[0]
    
            classSelector('userid').value =  v.user_id
            classSelector('firstname').value = v.firstname
            classSelector('lastname').value =  v.lastname
            classSelector('phone').value =  v.phone
            classSelector('email').value =  v.email
            classSelector('residence').value = v.residence
            classSelector('hire_date').valueAsDate =  new Date(v.hire_date)
            classSelector('birthdate').valueAsDate =  new Date(v.birthdate)
            classSelector('username').value = v.username

        })




    }

    if(e.target.matches('.addUserModalClass')){

        const addNewUser = async () => {

        const maxid = await fetch('router.php?controller=Widget&task=get_max_user_id')
        const userid = await maxid.text()
        const user_id = Number(userid) + 1

        /* Begin all selected previlleges */
        const previlleges = Array.from(document.querySelectorAll('.previllege'))

        let obj = []
        previlleges.forEach( v => {
            if(v.checked){

                const meun_id = v.value === 'Products'? 4 : v.value === 'Leads' ? 8 : v.value === 'SMS' ? 7 : 0

                const menu_parent = v.value === 'Salesinvoice'? 'previllege' : 'null'

                obj.push(
                    {
                        menu_name: v.value,	
                        menu_parent,
                        meun_id,	
                        user_id,
                    }
                )
            }
        })

        const menus = [
            {
                menu_name: 'Dashboard',	
                menu_parent: 'null',	
                meun_id: '1',		
                user_id
            },
            {
                menu_name: 'Sales',	
                menu_parent: 'null',	
                meun_id: '2',		
                user_id
            },
            {
                menu_name: 'Contacts',	
                menu_parent: 'null',	
                meun_id: '5',		
                user_id
            },
            {
                menu_name: 'Note',	
                menu_parent: 'null',	
                meun_id: '6',		
                user_id
            },
        ]

        const menu_items = Object.values([...menus,...obj]).map( v => Object.values(v)).flat(Infinity)


        /* End all selected previlleges */

        /* Begin form inputs */
        const forminputs = {
                user_id,
                firstname: classValueSelector('firstname'),
                lastname: classValueSelector('lastname'),
                phone: classValueSelector('phone'),
                residence: classValueSelector('residence'),
                email: classValueSelector('email'),
                hire_date: classValueSelector('hire_date'),
                birthdate: classValueSelector('birthdate'),
                username: classValueSelector('username'),
                password: classValueSelector('password'),
                repassword: classValueSelector('repassword'),
        }

        Spinner('addUserModalClass')

        const checkValueLength = Object.values(forminputs).map( v => v
        ).filter(Boolean)

        if(checkValueLength.length < 10) {
            return Error('addUserModalClass','All fields required!')
        }

        if(forminputs.password !== forminputs.repassword) { 
            return Error('addUserModalClass','Passwords do not match!')
        }

        /* End form inputs */

        const fd = new FormData()
        fd.append('users', JSON.stringify(forminputs))
        fd.append('menu', JSON.stringify(menu_items))

        const resp = await fetch('router.php?controller=User&task=add_user',
        {
            method: 'Post',
            body: new URLSearchParams(fd)
        })

        const data = await resp.text()

        if( data.indexOf('errors') != -1 ){
            Error('addUserModalClass', data)
        }
        else{
            Success('addUserModalClass',data)

            getUsers( ( data ) => {

                const arr = data.map( v => {
                    return v.users.map( v => {
                        return Lists({
                            editclass: 'edituser',
                            deltclass: 'deltuser',
                            fnameclass: 'ufname',
                            name: v.firstname+' '+v.lastname,
                            id: v.user_id
                        })
            
                    } )
                }).join('')

                classSelector('scroll-inner').innerHTML = arr

            })


        }

        
    }

    addNewUser()

    }


    if(e.target.matches('.ufname')){

        getUsers((data) => {
            const { id } = e.target.dataset

            const obj = Object.values(data).map( v => v.users.map(v => ({
                user_id: v.user_id,
                firstname: v.firstname,
                lastname: v.lastname,
                phone: v.phone,
                residence: v.residence,
                hire_date: v.hire_date
            }))).flat(Infinity)



            const getSingleUserdetails = obj.filter( v => v.user_id === id ).map( v => (userdetails(v))).join('')
    
            classSelector('col1').innerHTML = getSingleUserdetails

        })

    }

    if(e.target.matches('.addUser')){
        document.body.style.overflow = 'hidden'
        classSelector('modal-wrapper').classList.add('show')
    }

})


//This is the form inputs for users 
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
                classname: 'hire_date',
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
         ${
            textInput({
                type: 'hidden',
                classname: 'userid',
                required: false,
                label: ''
            })
         }
        </div>
    </div>

    ${Title('New User Previlleges')}

    <div class="addUserPrevileges">

    <div> 
        ${checkBox('previllege','Sales Invoice','Salesinvoice')}
        ${checkBox('previllege','Products','Products')}
    </div>
    <div> 
        ${checkBox('previllege','SMS','SMS')}
        ${checkBox('previllege','Leads','Leads')}
    </div>

    </div>
    
    `
)
    

//Create user page 
getUsers( ( data ) => {

    const arr = data.map( v => {
        return v.users.map( v => {
            return Lists({
                editclass: 'edituser',
                deltclass: 'deltuser',
                fnameclass: 'ufname',
                name: v.firstname+' '+v.lastname,
                id: v.user_id
            })

        } )
    }).join('')

        const output = `
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

        document.querySelector('.root').innerHTML = output
        classSelector('hire_date').valueAsDate = new Date()
        classSelector('col1').innerHTML = userdetails()

})





