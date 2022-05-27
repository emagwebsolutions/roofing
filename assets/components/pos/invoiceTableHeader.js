const invoiceTableHeader = ()=>{
	const output =  `
	<div class="col-md-1">Qty</div>
	<div class="col-md-4">Description</div>
	<div class="col-md-2">Duration (<span id="mduration"></span>)</div>
	<div class="col-md-2">Unit Price</div>
	<div class="col-md-2 text-right">Amount</div>
	<div class="col-md-1">Action</div>
	`
	document.querySelector('.invoice-table-header').innerHTML = output
}
export default invoiceTableHeader 