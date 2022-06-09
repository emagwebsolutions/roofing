

// addNewUserToDatabase(
//     classSelector,
//     classValueSelector,
//     getUsers,
//     Error,
//     Success,
//     getCheckInputValues1,
//     getInputFields,
//     Spinner,
//     clearFormFields,
//      List
// )


const addNewUserToDatabase = async (
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
) => {

    const getMaxId = await fetch('router.php?controller=Widget&task=get_max_user_id')
    const userid = await getMaxId.text()
    const user_id = Number(userid) + 1

    /* Begin all selected previlleges */
    const menu_items = getCheckInputValues1( user_id )
    /* End all selected previlleges */

    /* Begin form inputs */
    const forminputs = getInputFields(  classValueSelector,user_id )

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

export default addNewUserToDatabase
