
// deleteUser(
//     e,
//     getUsers,
//     classSelector,
//     Lists
// )

const deleteUser = (
    e,
    getUsers,
    classSelector,
    Lists
    ) => {

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
    else{}

}

export default deleteUser