
const taxesInputFields = ()=>{
	const output = `
		<div class="form-group  inputBox">
		<input type="text" id="covid" class="search covid graTaxes form-control">
		<label class="mt-1">COVID</i></label>	
		</div>

		<div class="form-group  inputBox">
		<input type="text" id="nhil"  class="search form-control nhil graTaxes">
		<label class="mt-1">NHIL %<i>(Optional)</i></label>	
		</div>	

		<div class="form-group  inputBox">
		<input type="text" id="getfund" class="search form-control getfund graTaxes">
		<label class="mt-1">GETFUND %<i>(Optional)</i></label>	
		</div>	

		<div class="form-group  inputBox">
		<input type="text" id="vatinp" class="search form-control vatinp graTaxes">
		<label class="mt-1">VAT  %<i>(Optional)</i></label>	
		</div>	

	`

	document.querySelector('.taxesInputFields').innerHTML = output

}
export default taxesInputFields