const getUsers = async () => {
	//Get data from users table 
	const userData = await fetch('router.php?controller=user&task=get_users')
	const users = await userData.json()

	//Get data from user_menu
	const usermenuData = await fetch('router.php?controller=user&task=get_user_menu')
	const user_menu = await usermenuData.json()

	//Get data from users_details
	const usersdetailsData = await fetch('router.php?controller=user&task=get_users_details')
	const users_details = await usersdetailsData.json()

	//Get data from note
	const noteData = await fetch('router.php?controller=user&task=get_note')
	const note = await noteData.json()

	const data = Object.values(users).map( v => {
		const user = {
			user_id	: v.user_id,
			username: v.username,	
			password: v.password,	
			email: v.email,
			user_date: v.user_date,	
			user_mang: v.user_mang,
			login_date: v.login_date,	
			login_status: v.login_status,	
			status: v.status,
			user_menu: Object.values(user_menu).filter( va => va.user_id === v.user_id),
			users_details: Object.values(users_details).filter( val => val.user_id === v.user_id),
			note: Object.values(note).filter( valu => valu.assigned === v.user_id)
		}
		return user
	})

	localStorage.setItem('usersDetails', JSON.stringify(data))

}
export default getUsers