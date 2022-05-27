			// textInput({
			// 		type: 'text',
			// 		classname: '',
			// 		required: true,
			// 		label: 'Full Name'
			// 	})

			// Button({
			// 	output: 'output1',
			// 	classname: '',
			// 	buttonname: 'SAVE'
			// })


	const textInput = ( obj )=>{

		const { type,classname,required,label,placeholder } = Object.assign(
			{
				type: 'text',
				classname: '',
				required: true,
				label: 'Full Name',
				placeholder: ' '
			},
			obj
		)
		return `
		<div class="form-group  pt-0 input-animate">	
			<input type="${type}"  placeholder="${placeholder}" class="fminpt form-control ${classname}" required="${required}" readonly>
			<label>${label}</label>
		</div>`
	}

	

	const textArea = ( obj )=>{

		const { classname,placeholder } = Object.assign(
			{
				classname: '',
				placeholder: ' '
			},
			obj
		)
		return `
		<div class="form-groupe">	
			<textarea class="${classname} message-box" placeholder="${placeholder}"></textarea>
		</div>`
	}

	

	const Button = ( obj )=>{
		const { output,classname,buttonname } = Object.assign({
			output: 'output1',
			classname: '',
			buttonname: 'SAVE'
		},obj)
		return `
		<div class="results ${output}"></div>
		<div class="submitbtn">
		<a href="javascript:void(0);"  class="button-rounded 
		${classname}">${buttonname.toUpperCase()}</a>
		</div>`
	}

	const Titlebar = ( title )=>{
		return `
			<div class="heading-title">
			${title}
			</div>
		`
	}

	const checkBox = ( classname,labelname ) => {
		return `
		<div class="checkbox-group">
			<input type="checkbox"  class="${classname}" />
			<label>${labelname}</label>
		</div>
		`
	}

	export {textInput,textArea,Button,Titlebar,checkBox}


