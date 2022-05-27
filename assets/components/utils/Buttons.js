const Buttons = ( obj ) => {

	console.log(Object.values(obj[0]))

	return `
	<div class="bg-white mb-1 flex top-btns">
	${
		Object.values(obj).map( v => (`
		<button class="${v.btnclass}">
		${v.btnname}
		</button>`)).join('')
	}
	</div>
	`
}

export default Buttons