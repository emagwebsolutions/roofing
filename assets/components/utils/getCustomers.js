const getCustomers = async ( callback )=>{
	//Get data from customer table 
	const custData = await fetch('router.php?controller=customer&task=all_customers')
	const customers = await custData.json()

	//Get data from sales
	const salesData = await fetch('router.php?controller=customer&task=getCustomerSales')
	const sales = await salesData.json()

	//Get data from receipts
	const receiptData = await fetch('router.php?controller=customer&task=getCustomersReceipts')
	const receipts = await receiptData.json()

	const data = Object.values(customers).map( v => {
		const cust = {
			ac_id: v.ac_id,
			cust_id: v.cust_id,
			date: v.date,
			email: v.email,
			fullname: v.fullname,
			funds: v.funds,
			location: v.location,
			note: v.note,
			phone: v.phone,
			type: v.type,
			user_id: v.user_id,
			user_mang: v.user_mang,
			sales: Object.values(sales).filter( va => va.cust_id === v.cust_id),
			receipts: Object.values(receipts).filter( re => re.cust_id === v.cust_id)
		}
		return cust
	})

	callback(data)
}
export default getCustomers