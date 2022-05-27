const invoiceTableBody = (obj)=>{
	const df = {
		s_id: '',
		remaining: '',
		prod_qty: 1,
		prod_name: '',
		duration: '',
		cat_name: '',
		selling_price: '',
		prod_id: '',
		amount: 0
	}


	const v = Object.assign(df,obj)
	let calc = (Number(v.amount) < 1)? Number(v.selling_price) : Number(v.amount)

	return  `
		<div class="prodCalc col-sm-1 border border-top-0 border-right-0 p-0">
		<input type="text" data-remaining="${v.remaining}" value="${v.prod_qty}" id="qty" autocomplete="off"   required  class="p_qty calc form-control border-0"/>

		</div>

		<div class="prodName col-sm-4 border der-top-0  border-right-0 p-0">
		<input type="text" value="${v.prod_name}" id="prod_name" autocomplete="off"   required  class="prod_name form-control border-0">
		<input type="hidden" value="${v.cat_name}" class="cat_name"/>
		</div>

		<div class="col-md-2 border border-top-0  border-right-0 p-0 prodCalc">
		<input type="text"  required value="${v.duration}" id="duration"  class="duration form-control border-0 calc"/>
		</div>

		<div class="col-md-2 border border-top-0  border-right-0 p-0  prodCalc">
		<input type = "text" required  value="${v.selling_price}" id="selling_price"  class="price form-control border-0 calc">
		</div>

		<div class="col-md-2 border border-top-0   p-0 tot ">
		<input type="text"  disabled id="amount"  class="calc-amount form-control text-right border-0" value="${calc}" />
		<input type="hidden" value="${v.prod_id}"  class="prod_id"/>
		</div>

		<div class="col-md-1 p-0  border border-top-0 "> 
		<a href="javascript:void(0);" id="delete"  >
		<i data-s_id="${v.s_id}" class="deleteRow fa fa-trash fa-xs ml-3 text-dark delete-row" title="Delete Row" ></i>
		</a>
		<input type="hidden"  value="${v.s_id}"  class="s_id"/>
		</div>
	`
}
export default invoiceTableBody 