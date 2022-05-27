const timeAgo = (date) => {
	const units = [1000,60,60,24,30,12]
	const ref = ['sec','min','hr','day','month','year']
	const curdate = new Date().getTime()
	const pdate = new Date(date).getTime()
	let diff = Number(curdate) - Number(pdate)
	let k  = []
	if(curdate >= pdate){
		for(let i=0; diff >= units[i] && i < units.length; i++){
			diff = diff/units[i]
			k.push(i)
		}
		return Math.round(diff)+' '+ref[k.pop()]+'(s) ago'
	}
}

export default timeAgo