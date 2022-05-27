const Error = ( outputClass,message ) => {
	return document.querySelector(`.${outputClass}`).innerHTML = `
	ERROR: ${message}
	`;
}

export default Error