const Success = ( outputClass,message ) => {

	setTimeout( () => {
		document.querySelector('.modal-wrapper').classList.remove('show')
		document.querySelector(`.${outputClass}`).textContent = 'SAVE'
		document.body.style.overflow = 'scroll'

		const text = document.querySelectorAll('[type="text"')
		text && Array.from(text).forEach( v => v.value = null)

		const checkbox = document.querySelectorAll('[type="checkbox"')
		checkbox && Array.from(checkbox).forEach( v => v.checked = false)
	}, 1000)

	return document.querySelector(`.${outputClass}`).textContent = `
	SUCCESS: ${message}
	`;


}

export default Success