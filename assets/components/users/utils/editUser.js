
// editUser(
//     e,
//     getUsers,
//     classSelector,
//     clearUserCheckboxAndDataset 
// )

const editUser = (
    e,
    getUsers,
    classSelector,
    clearUserCheckboxAndDataset 
) => {

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

    export default editUser