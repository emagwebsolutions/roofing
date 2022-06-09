
// editNewUserAndSaveToDatabase(
//     classSelector,
//     classValueSelector,
//     getUsers,
//     Error,
//     Success,
//     getCheckInputValues2,
//     getInputFields, 
//     Spinner,
//     Lists
// )


const editNewUserAndSaveToDatabase = async (
    classSelector,
    classValueSelector,
    getUsers,
    Error,
    Success,
    getCheckInputValues2,
    getInputFields, 
    Spinner,
    Lists
) => {

    const user_id = classSelector('userid').value

    /* Begin all selected previlleges */
    const menu_items = getCheckInputValues2(user_id)

    /* Begin form inputs */
    const forminputs = getInputFields(classValueSelector, user_id )

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

export default editNewUserAndSaveToDatabase