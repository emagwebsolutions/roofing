const invoiceTableFooter = ()=>{
	const output =  `
		<div class="row">
			<div class="col-md-7"></div>
			<div class="col-md-2 p-0 text-right pr-2">Sub Total</div>
			<div class="col-md-2 border border-top-0 p-0">
			<input type="text" readonly  value="" id="subtotal"  class="form-control text-right  subtotal   totalall border-0"/>
			</div>
			<div class="col-md-1">
				<a href="javascript:void(0);"   >
				<i class="deletetax fa fa-trash fa-xs ml-3 text-dark" title="Delete Tax" ></i>
				</a>
			</div>
		</div>	


		<div class="row">
			<div class="col-md-7  p-0"></div>
			<div class="col-md-2  p-0 text-right pr-2"">Discount</div>
			<div class="col-md-2 border  border-top-0 p-0">
			<input type="text"  readonly   id="discount"   class="discount  totalall form-control text-right border-0"/>
			</div>
			<div class="col-md-1">
				<a href="javascript:void(0);"   >
				<i class="deletetax fa fa-trash fa-xs ml-3 text-dark" title="Delete Tax" ></i>
				</a>
			</div>
		</div>

		<div class="row">
			<div class="col-md-7  p-0"></div>
			<div class="col-md-2  p-0 text-right pr-2"">NHIL</div>
			<div class="col-md-2 border  border-top-0 p-0">
			<input type="text" readonly  value=""  id="nhils" class="nhils form-control text-right  totalall border-0"/>
			</div>
			<div class="col-md-1">
				<a href="javascript:void(0);"   >
				<i class="deletetax fa fa-trash fa-xs ml-3 text-dark" title="Delete Tax" ></i>
				</a>
			</div>
		</div>


		<div class="row">
			<div class="col-md-7  p-0"></div>
			<div class="col-md-2  p-0 text-right pr-2"">COVID</div>
			<div class="col-md-2 border  border-top-0 p-0">
			<input type="text" readonly  value=""  id="covids" class="covids form-control text-right  totalall border-0"/>
			</div>
			<div class="col-md-1">
				<a href="javascript:void(0);"   >
				<i class="deletetax fa fa-trash fa-xs ml-3 text-dark" title="Delete Tax" ></i>
				</a>
			</div>
		</div>


		<div class="row">
			<div class="col-md-7  p-0"></div>
			<div class="col-md-2  p-0 text-right pr-2"">Getfund</div>
			<div class="col-md-2 border  border-top-0 p-0">
			<input type="text" readonly value=""  id="getfunds" class="form-control text-right getfunds  totalall border-0"/>
			</div>
			<div class="col-md-1">
				<a href="javascript:void(0);"   >
				<i class="deletetax fa fa-trash fa-xs ml-3 text-dark" title="Delete Tax" ></i>
				</a>
			</div>
		</div>	


		<div class="row">
			<div class="col-md-7  p-0"></div>
			<div class="col-md-2  p-0 text-right pr-2"">VAT</div>
			<div class="col-md-2 border  border-top-0 p-0">
			<input type="text" readonly  value=""   id="vat" class="form-control text-right vat totalall border-0"/>
			</div>
			<div class="col-md-1">
				<a href="javascript:void(0);"   >
				<i class="deletetax fa fa-trash fa-xs ml-3 text-dark" title="Delete Tax" ></i>
				</a>
			</div>
		</div>	


		<div class="row">
			<div class="col-md-7  p-0"></div>
			<div class="col-md-2  p-0 text-right pr-2">Total GHs</div>
			<div class="col-md-2 border  border-top-0 p-0"> 
			<input type="text" readonly id="grandtotal" value="" class="form-control text-right  grandtotal border-0"/>  
			</div>
			<div class="col-md-1">
	
			</div>
		</div>	
	`
	document.querySelector('.tbFooter').innerHTML = output
}
export default invoiceTableFooter