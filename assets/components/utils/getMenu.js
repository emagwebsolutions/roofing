const getMenu = async ( callback )=>{
	//Get data from customer table 
	const menu = await fetch('router.php?controller=settings&task=menu')
	const data = await menu.json()
	callback(data)
}
export default getMenu