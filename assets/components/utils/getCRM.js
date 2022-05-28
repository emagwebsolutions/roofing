const getCRM = async ( callback )=>{

	//Get data from customer table 
	const crmData = await fetch('router.php?controller=Crm&task=get_crm')
	const crm = await crmData.json()

	//Get data from customer table 
	const noteData = await fetch('router.php?controller=Crm&task=get_crm_note')
	const note = await noteData.json()

	const c = crm.map( v => {

		return {
			crm_id: 		v.crm_id,
			contactname: 	v.contactname,
			company: 		v.company,
			industry: 		v.industry,
			email: 			v.email,
			url: 			v.url,
			phone: 			v.phone,
			mobile: 		v.mobile,
			lead_source: 	v.lead_source,
			lead_status:	v.lead_status,
			sales_stage: 	v.sales_stage,
			skype: 			v.skype,
			twitter: 		v.twitter,
			facebook: 		v.facebook,
			region: 		v.region,
			city: 			v.city,
			description: 	v.description,
			opp_name: 		v.app_name,
			closing_date: 	v.closing_date,
			stage: 			v.stage,
			type: 			v.type,
			probability: 	v.probability,
			revenue: 		v.revenue,
			category: 		v.category,
			date: 			v.date,
			cust_id: 		v.cust_id,
			user_id: 		v.user_id,
			note: Object.values(note).filter( va => va.assigned === v.user_id)
		}


	})

	callback(c)
}
export default getCRM