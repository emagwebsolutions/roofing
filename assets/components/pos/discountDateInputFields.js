
const discountDateInputFields = ()=>{
	const output = `
		<div class="form-group has-feedback inputBox">
			<input type="text" id="discountinpt" class="search discountinpt graTaxes form-control" >
			<label class="mt-1">DISCOUNT % <i>(Optional)</i></label>	
		</div>	
	
		<div class="form-group has-feedback inputBox">
			<input type="text" class="search form-control project" required>
			<label>INVOICE DESCRIPTION</label>	
		</div>

		<div class="form-group has-feedback inputBox">
			<input type="date" class="search form-control pro_date calendar"  required>
			<label>INVOICE DATE:</label>	
		</div>	

		<div class="form-group has-feedback inputBox">
			<input type="date" class="search exp_date form-control calendar2">
			<label class="mt-1">SCHEDULE PAYMENT</label>	
		</div>

	`

	document.querySelector('.discountDateInputFields').innerHTML = output

}
export default discountDateInputFields