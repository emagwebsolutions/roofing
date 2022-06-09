// displayAllUserDetails(
//     e,
//     getUsers,
//     classSelector,
//     onclickDisplayAsingleUser,
//     populateUserTabs,
//     Table,
//     formatDate
// )

const displayAllUserDetails = (
    e,
    getUsers,
    classSelector,
    onclickDisplayAsingleUser,
    populateUserTabs,
    Table,
    formatDate
) => {
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

        populateUserTabs(classSelector,data,Table,formatDate,id)

    })
}

export default displayAllUserDetails