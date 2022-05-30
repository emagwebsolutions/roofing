const Success = ( outputClass,message ) => {

	setTimeout( () => {
		document.querySelector('.modal-wrapper').classList.remove('show')
		document.querySelector(`.${outputClass}`).textContent = 'SAVE'
		document.body.style.overflow = 'scroll'
	}, 1000)

	return document.querySelector(`.${outputClass}`).textContent = `
	SUCCESS: ${message}
	`;


}

export default Success