
//getInputFields( classValueSelector,user_id )

const getInputFields = ( classValueSelector,user_id ) => {
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

export default getInputFields