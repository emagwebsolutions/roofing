const Error = ( outputClass,message ) => {
	return document.querySelector(`.${outputClass}`).innerHTML = `
	<div class="error-color">${message}</div>
	`;
}

export default Error