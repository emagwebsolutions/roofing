const Error = ( outputClass,message ) => {
	setTimeout(()=>{
		document.querySelector(`.${outputClass}`).innerHTML = 'SAVE'
	},4000)
	return document.querySelector(`.${outputClass}`).innerHTML = `
	ERROR: ${message}
	`;
}

export default Error