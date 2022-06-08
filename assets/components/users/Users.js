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
import { textInput,checkBox,textArea } from '../utils/inputFields.js'
import Title from '../utils/Title.js'
import clearFormFields from '../utils/clearFormFields.js'
import Table from '../utils/Table.js'
import Modalboxtwo from '../widgets/Modalboxtwo.js'
import { Tabs,tabContent,tabMenu } from '../utils/Tabs.js'


const clearNoteFields = () => {
    classSelector('noteid').value =  null
    classSelector('notemessage').value = null
    classSelector('notedate').valueAsDate = null
}
const populateUserTabs = (data,Table,formatDate,id) => {

    //BEGIN NOTE
    const notes = Object.values(data).map( v => v.note.map(v => ({
        note_id: v.note_id,
        id: v.id,
        message: v.message,
        date: v.date
    }))).flat(Infinity)

    const getDetailsOfUserNote = notes.filter( v => v.id === id ).map( v => (`
        <ul>
            <li class="col-100">${formatDate(v.date)}</li>
            <li class="col-600">${v.message.substring(0,50)}......</li>
            <li class="col-100 flex gap-2">
                <i class="fa fa-edit edit-note cursor" title="EDIT" data-id="${v.note_id}"></i>
                <i class="fa fa-trash delete-note cursor" title="DELETE" data-id="${v.note_id}"></i>
            </li>
        </ul>
    `)).join('')

    
    const tablehead = `
    <ul>
    <li class="col-100">Date</li>
    <li class="col-600">Message</li>
    <li class="col-100">Action</li>
    </ul>
    `

    const tablebody = getDetailsOfUserNote

    classSelector('tabs-content').innerHTML = `
    <div id="tab1" class="active hide-tab">
    ${Table(tablehead,tablebody)}
    </div>
    `
    //END NOTE

}

// This function displays list of users
const onclickDisplayAsingleUser = ( v ) => {
    const date = v?.hire_date ? formatDate(v?.hire_date)  : ''
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


const getCheckInputValues1 = ( user_id ) => {
    const previlleges = Array.from(document.querySelectorAll('.previllege'))

    let obj = []
    previlleges.forEach( v => {
        if(v.checked ){

            const meun_id = v.value === 'Products'? 4 : v.value === 'Leads' ? 8 : v.value === 'SMS' ? 7 : 10

            const menu_parent = v.value === 'Salesinvoice'? 'Privileges' : 'null'

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
    return menu_items

}

const getCheckInputValues2 = ( user_id ) => {

    const previlleges = Array.from(document.querySelectorAll('.previllege'))

    let obj = []

    previlleges.forEach( v => {
        if(v.checked && !v.dataset.menu_id ){

            const meun_id = v.value === 'Products'? 4 : v.value === 'Leads' ? 8 : v.value === 'SMS' ? 7 : 10

            const menu_parent = v.value === 'Salesinvoice'? 'Privileges' : 'null'

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

    const menu_items = Object.values([...obj]).map( v => Object.values(v)).flat(Infinity)

    return menu_items

}

const getInputFileds = ( user_id ) => {
    return {
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
}


const addNoteToDatabase = async () => {

    const fd = new FormData()

    const id = classSelector('uid').value
    const message = classSelector('notemessage').value
    fd.append('id', id)
    fd.append('message', message)
    fd.append('date', classSelector('notedate').value)

    const resp = await fetch('router.php?controller=Note&task=add_note',
    {
        method: 'Post',
        body: new URLSearchParams(fd)
    })

    const data = await resp.text()

    if( data.indexOf('errors') != -1 ){
        Error('addNoteModalClass', data)
    }
    else{
        Success('addNoteModalClass',data,'modal-wrapper2')
        classSelector('notemessage').value = null

        getUsers( data => {
            populateUserTabs(data,Table,formatDate,id)
        })
    }

}

const editNoteAndSaveToDatabase = async () => {
    const fd = new FormData()
    const note_id = classSelector('noteid').value
    const user_id = classSelector('uid').value

    fd.append('note_id', note_id)
    fd.append('message', classSelector('notemessage').value)
    fd.append('date', classSelector('notedate').value)

    const resp = await fetch('router.php?controller=Note&task=edit_note',
    {
        method: 'Post',
        body: new URLSearchParams(fd)
    })

    const data = await resp.text()

    if( data.indexOf('errors') != -1 ){
        Error('addNoteModalClass', data)
    }
    else{
        Success('addNoteModalClass',data,'modal-wrapper2')
        getUsers( data => {
            populateUserTabs(data,Table,formatDate,user_id)
        })
    }


}



const addNewUserToDatabase = async () => {

    const getMaxId = await fetch('router.php?controller=Widget&task=get_max_user_id')
    const userid = await getMaxId.text()
    const user_id = Number(userid) + 1

    /* Begin all selected previlleges */
    const menu_items = getCheckInputValues1( user_id )
    /* End all selected previlleges */

    /* Begin form inputs */
    const forminputs = getInputFileds( user_id )

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
        clearFormFields()
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


const editNewUserAndSaveToDatabase = async () => {

    const user_id = classSelector('userid').value

    /* Begin all selected previlleges */
    const menu_items = getCheckInputValues2(user_id)

    /* Begin form inputs */
    const forminputs = getInputFileds( user_id )

    Spinner('addUserModalClass')

    const checkValueLength = Object.values(forminputs).map( v => v
    ).filter(Boolean)

    if(checkValueLength.length < 8) {
        return Error('addUserModalClass','Fill all required fields!')
    }

    if(forminputs.password){
        if(forminputs.password !== forminputs.repassword) { 
            return Error('addUserModalClass','Passwords do not match!')
        }
    }


    /* End form inputs */

    const fd = new FormData()
    fd.append('users', JSON.stringify(forminputs))
    fd.append('menu', JSON.stringify(menu_items))

    const resp = await fetch('router.php?controller=User&task=update_user',
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

const clearUserCheckboxAndDataset = () => {

    Array.from(document.querySelectorAll('.previllege')).forEach( v =>{
        v.checked = false
        v.classList.remove('checkClick')
        v.removeAttribute('data-menu_id')
        v.removeAttribute('data-user_id')

    })

}


//Search database 
document.addEventListener('keyup', e => {

    if(e.target.matches('.search-users')){
        const val = e.target.value 
        getUsers( ( data ) => {
            const arr = data.map( v => {
                return v.users.map( v => v)
            })
            .flat(Infinity)
            .filter( v => Object.values(v).join('').toLowerCase().includes(val.toLowerCase()) )
            .map( v => ( 
                Lists({
                    editclass: 'edituser',
                    deltclass: 'deltuser',
                    fnameclass: 'ufname',
                    name: v.firstname+' '+v.lastname,
                    id: v.user_id
                })
            )).join('')
            classSelector('scroll-inner').innerHTML = arr
        })
    }


})


//Start click events 
document.addEventListener('click', e => {

    if(e.target.matches('.addNote')){
        clearNoteFields()
        classSelector('modal-wrapper2').classList.add('show')
    }

    if(e.target.matches('.delete-record')){
        const { id } = e.target.dataset 

        if(confirm('Are you sure you want to delete!')){
            fetch(`router.php?controller=User&task=delete_user&user_id=${id}`)
            
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
        else{

    }
 
  
    }





    if(e.target.matches('.delete-note')){
        const  id  = e.target.dataset.id
        const user_id = classSelector('uid').value

        if(confirm('Are you sure you want to delete!')){
            fetch(`router.php?controller=Note&task=delete_note&note_id=${id}`)

            getUsers( data => {
                populateUserTabs(data,Table,formatDate,user_id)
            })
        }
        else{ }
 
  
    }




    if(e.target.matches('.checkClick')) {
        const deleteUserPrivilege = async () => {
            const { menu_id, user_id } = e.target.dataset 

            if(confirm('Are you sure you want to remove!')){
                const f = await fetch(`router.php?controller=User&task=delete_menu&u=${user_id}&m=${menu_id}`)
                e.target.classList.remove('checkClick')
                e.target.removeAttribute('data-menu_id')
                e.target.removeAttribute('data-user_id')
            }
            else{
                e.target.checked = true
            }
        }
        deleteUserPrivilege()
    }


    if(e.target.matches('.edit-record')) {
        //On click display and edit a user
        document.body.style.overflow = 'hidden'
        classSelector('modal-wrapper').classList.add('show')

        getUsers((data) => {
            const { id } = e.target.dataset

            //Loop through all users
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

            //Get single user by id
            const v = obj.filter( v => v.user_id === id )[0]
    
            //Populate user input field 
            classSelector('userid').value =  v.user_id
            classSelector('firstname').value = v.firstname
            classSelector('lastname').value =  v.lastname
            classSelector('phone').value =  v.phone
            classSelector('email').value =  v.email
            classSelector('residence').value = v.residence
            classSelector('hire_date').valueAsDate =  new Date(v.hire_date)
            classSelector('birthdate').valueAsDate =  new Date(v.birthdate)
            classSelector('username').value = v.username
  
            //Loop through user privileges or menus 
            const menus = Object.values(data).map( v => v.user_menu.map(v => ({
                user_id: v.user_id,
                menu_id: v.menu_id
            }))).flat(Infinity)

            //Populate checkbox of a user
            clearUserCheckboxAndDataset() 
            const m = menus.filter( v => v.user_id === id )
       
            m.forEach( v => {


                if(v.menu_id == 4){
                    classSelector('products').checked = true
                    classSelector('products').classList.add('checkClick')
                    classSelector('products').setAttribute('data-menu_id', v.menu_id)
                    classSelector('products').setAttribute('data-user_id', v.user_id)
                }

                if(v.menu_id == 7){
                    classSelector('sms').checked = true
                    classSelector('sms').classList.add('checkClick')
                    classSelector('sms').setAttribute('data-menu_id', v.menu_id)
                    classSelector('sms').setAttribute('data-user_id', v.user_id)
                }

                if(v.menu_id == 8){
                    classSelector('leads').checked = true
                    classSelector('leads').classList.add('checkClick')
                    classSelector('leads').setAttribute('data-menu_id', v.menu_id)
                    classSelector('leads').setAttribute('data-user_id', v.user_id)
                }

                if(v.menu_id == 10){
                    classSelector('salesinvoice').checked = true
                    classSelector('salesinvoice').classList.add('checkClick')
                    classSelector('salesinvoice').setAttribute('data-menu_id', v.menu_id)
                    classSelector('salesinvoice').setAttribute('data-user_id', v.user_id)
                }
            })


          
            

        })

    }


    if(e.target.matches('.addUserModalClass')){
            if(document.querySelector('.userid').value){
                editNewUserAndSaveToDatabase()
            }
            else{
                addNewUserToDatabase()
            }
    }

    if(e.target.matches('.addNoteModalClass')){
            if(document.querySelector('.noteid').value){
                editNoteAndSaveToDatabase()
            }
            else{
                addNoteToDatabase()
            }
    }

    
    if(e.target.matches('.edit-note')) {
        //On click display and edit a user
        document.body.style.overflow = 'hidden'
        classSelector('modal-wrapper2').classList.add('show')

        getUsers((data) => {
  
            const id  = e.target.dataset.id

            const notes = Object.values(data).map( v => v.note.map(v => ({
                note_id: v.note_id,
                id: v.id,
                message: v.message,
                date: v.date
            }))).flat(Infinity)
        
            const v = notes.filter( v => v.note_id === id )[0]

            clearNoteFields()

            //Populate user input field 
            classSelector('noteid').value =  v.note_id
            classSelector('notemessage').value = v.message
            classSelector('notedate').valueAsDate =  new Date(v.date)
        })

    }


    if(e.target.matches('.ufname')){

        //Onclick get a user details and display 
        getUsers((data) => {
            const { id } = e.target.dataset

            classSelector('uid').value = id

            //Get user details
            const obj = Object.values(data).map( v => v.users.map(v => ({
                user_id: v.user_id,
                firstname: v.firstname,
                lastname: v.lastname,
                phone: v.phone,
                residence: v.residence,
                hire_date: v.hire_date
            }))).flat(Infinity)

            const getDetailsOfUser = obj.filter( v => v.user_id === id ).map( v => (onclickDisplayAsingleUser(v))).join('')
    
            classSelector('col1').innerHTML = getDetailsOfUser

            populateUserTabs(data,Table,formatDate,id)

        })

        classSelector('addNote').classList.add('show')

    }

    if(e.target.matches('.addUser')){
        //Show modal box when add user button is clicked
        document.body.style.overflow = 'hidden'
        clearFormFields()
        clearUserCheckboxAndDataset() 
        classSelector('modal-wrapper').classList.add('show')
    }

})

//This is the form inputs for users 
const addNoteForm = () => (`
    <br><br>
    ${
        textInput({
            type: 'date',
            classname: 'notedate',
            required: true,
            label: 'Date'
        })
    }

    ${
        textArea({
            classname: 'notemessage',
            placeholder: 'Message'
        })
    }
    <br>
`)


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
        ${checkBox('previllege salesinvoice','Sales Invoice','Salesinvoice')}
        ${checkBox('previllege products','Products','Products')}
    </div>
    <div> 
        ${checkBox('previllege sms','SMS','SMS')}
        ${checkBox('previllege leads','Leads','Leads')}
    </div>

    </div>
    
    `
)

//Create user page and add to the user.html page 
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



    // BEGIN TABS
    const tabMenuObj = [
        {name: 'Note', active: 'active',tabTarget: 'tab1'}
    ]

    let tabContentObj = [
        {
            tab:  `
                <div id="tab1" class="active hide-tab">
    
                </div>
            `
        },
        {
            tab:  `
                <div id="tab2" class="hide-tab">
    
                </div>
            `
        }
    ]


    // END TABS

    const output = `
        <div class="container mb-2">
        <div class="row gap-3">

            <div class="sidebar bg-white">
                ${Sidebar(searchBox('search-users','Search users'),arr)}
                <input type="hidden" class="uid">
                <input type="hidden" class="noteid">
            </div>

            <div class="cont">
                ${Buttons([
                    {
                        btnclass: 'addUser',
                        btnname: 'Add User'
                    },
                    {
                        btnclass: 'addNote hidebtn',
                        btnname: 'Add Note'
                    }
                ])}
                ${ DetailsBox('col1','col2') }
                ${Tabs(tabMenu(tabMenuObj),tabContent(tabContentObj))}

            </div>
        </div>
        </div>

    ${Modalbox('ADD USER','addUserModalClass', addUserForm())}
    ${Modalboxtwo('NOTE','addNoteModalClass', addNoteForm())}
    `

    document.querySelector('.root').innerHTML = output
    classSelector('hire_date').valueAsDate = new Date()
    classSelector('col1').innerHTML = onclickDisplayAsingleUser()

    document.querySelector('.notedate').valueAsDate = new Date()

})








