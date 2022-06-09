import Lists from "../utils/Lists.js"
import searchBox from "../utils/searchBox.js"
import Sidebar from "../utils/Sidebar.js"
import getUsers from "../utils/getUsers.js"
import { classSelector,classValueSelector } from "../utils/Selectors.js"
import DetailsBox from "../utils/DetailsBox.js"
import Buttons from '../utils/Buttons.js'
import Modalbox from '../widgets/Modalbox.js'
import clearFormFields from '../utils/clearFormFields.js'
import Modalboxtwo from '../widgets/Modalboxtwo.js'
import ModalDisplayDetails from '../widgets/ModalDisplayDetails.js'
import { Tabs,tabContent,tabMenu } from '../utils/Tabs.js'
import clearNoteFields from './utils/clearNoteFields.js'
import onclickDisplayAsingleUser from './utils/onclickDisplayAsingleUser.js'
import addNoteToDatabase from './utils/addNoteToDatabase.js'
import editNoteAndSaveToDatabase from './utils/editNoteAndSaveToDatabase.js'
import addNewUserToDatabase from './utils/addNewUserToDatabase.js'
import editNewUserAndSaveToDatabase from './utils/editNewUserAndSaveToDatabase.js'
import clearUserCheckboxAndDataset from './utils/clearUserCheckboxAndDataset.js'
import addNoteForm from './utils/addNoteForm.js'
import viewNoteForm from './utils/viewNoteForm.js'
import addUserForm from './utils/addUserForm.js'
import searchUsers from './utils/searchUsers.js'
import deleteUser from './utils/deleteUser.js'
import deleteNote from './utils/deleteNote.js'
import deleteUserPrevilege from './utils/deleteUserPrevilege.js'
import editUser from './utils/editUser.js'
import editNote from './utils/editNote.js'
import displayAllUserDetails from './utils/displayAllUserDetails.js'
import Error from '../utils/Error.js'
import Success from '../utils/Success.js'
import getInputFields from './utils/getInputFields.js'
import Spinner from '../utils/Spinner.js'
import { textInput,textArea,checkBox, } from '../utils/inputFields.js'
import populateUserTabs from './utils/populateUserTabs.js'
import Title from '../utils/Title.js'
import getCheckInputValues1 from './utils/getCheckInputValues1.js'
import getCheckInputValues2 from './utils/getCheckInputValues2.js'
import { formatDate } from "../utils/DateFormats.js"
import Table from "../utils/Table.js"
import viewNote from "./utils/viewNote.js"


document.addEventListener('keyup', e => {
    if(e.target.matches('.search-users')){
        searchUsers(
            e,
            getUsers,
            classSelector,
            Lists
        )
    }
})

document.addEventListener('click', e => {
    if(e.target.matches('.addNote')) {
        clearNoteFields(classSelector)
        classSelector('modal-wrapper2').classList.add('show')
        document.querySelector('.notedate').valueAsDate = new Date()
    }
    if(e.target.matches('.delete-record')) {
        deleteUser(
            e,
            getUsers,
            classSelector,
            Lists
        )
    }
    if(e.target.matches('.delete-note')) {
        deleteNote(
            e,
            getUsers,
            classSelector,
            populateUserTabs,
            Table,
            formatDate
        )
    }

    if(e.target.matches('.checkClick')) {
        deleteUserPrevilege(e)
    }

    if(e.target.matches('.edit-record')) {
        editUser(
            e,
            getUsers,
            classSelector,
            clearUserCheckboxAndDataset 
        )
    }


    if(e.target.matches('.addUserModalClass')){
        if(document.querySelector('.userid').value){
            editNewUserAndSaveToDatabase(
                classSelector,
                classValueSelector,
                getUsers,
                Error,
                Success,
                getCheckInputValues2,
                getInputFields, 
                Spinner,
                Lists
            )
        }
        else{
            addNewUserToDatabase(
                classSelector,
                classValueSelector,
                getUsers,
                Error,
                Success,
                getCheckInputValues1,
                getInputFields,
                Spinner,
                clearFormFields,
                Lists
            )
        }
    }

    if(e.target.matches('.addNoteModalClass')){
        if(document.querySelector('.noteid').value){
            editNoteAndSaveToDatabase(
                classSelector,
                getUsers,
                populateUserTabs,
                Error,
                Success,
                Table,
                formatDate
            )
        }
        else{
            addNoteToDatabase(
                classSelector,
                getUsers,
                populateUserTabs,
                Error,
                Success,
                Table,
                formatDate
            )
        }
    }

    if(e.target.matches('.edit-note')) {
        document.body.style.overflow = 'hidden'
        classSelector('modal-wrapper2').classList.add('show')
        editNote(
            e,
            getUsers,
            classSelector,
            clearNoteFields 
        )
    }

    if(e.target.matches('.view-note')) {
        viewNote(
            e,
            getUsers,
            classSelector,
            clearNoteFields
        ) 
    }

    if(e.target.matches('.ufname')){
        displayAllUserDetails(
            e,
            getUsers,
            classSelector,
            onclickDisplayAsingleUser,
            populateUserTabs,
            Table,
            formatDate
        )
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


//CREATE USERS PAGE
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

    ${Modalbox('ADD USER','addUserModalClass', addUserForm(textInput,checkBox,Title))}
    ${Modalboxtwo('NOTE','addNoteModalClass', addNoteForm(textInput,textArea))}
    ${ModalDisplayDetails('NOTE',viewNoteForm(textInput,textArea))}
    `
    
    document.querySelector('.root').innerHTML = output
    classSelector('hire_date').valueAsDate = new Date()
    classSelector('col1').innerHTML = onclickDisplayAsingleUser()

    

})








