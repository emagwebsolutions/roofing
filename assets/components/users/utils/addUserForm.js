
// addUserForm(textInput,checkBox,Title)

const addUserForm = (textInput,checkBox,Title) => (
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

export default addUserForm