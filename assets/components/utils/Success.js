const Success = ( outputClass,message ) => {
	return document.querySelector(`.${outputClass}`).innerHTML = `
	<div class="success-color">${message}</div>
	`;
}

export default Success