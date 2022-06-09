
// searchUsers(
//     e,
//     getUsers,
//     classSelector,
//     Lists
// )


const searchUsers = (
    e,
    getUsers,
    classSelector,
    Lists
) => {
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

export default searchUsers