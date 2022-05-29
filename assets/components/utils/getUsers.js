const getUsers = async ( callback ) => {
	//Get data from users table 
	const userData = await fetch('router.php?controller=User&task=get_users')
	const users = await userData.json()

	//Get data from user_menu
	const usermenuData = await fetch('router.php?controller=User&task=get_user_menu')
	const user_menu = await usermenuData.json()

	//Get data from note
	const noteData = await fetch('router.php?controller=User&task=get_note')
	const note = await noteData.json()

	const data = Object.values(users).map( v => {
		const user = {
			user_id	: v.user_id,
			username: v.username,	
			password: v.password,	
			email: v.email,
			date: v.date,	
			status: v.status,
			user_menu: Object.values(user_menu).filter( va => va.user_id === v.user_id),
			users: Object.values(users).filter( val => val.user_id === v.user_id),
			note: Object.values(note).filter( valu => valu.assigned === v.user_id)
		}
		return user
	})


	return callback(data)

}
export default getUsers