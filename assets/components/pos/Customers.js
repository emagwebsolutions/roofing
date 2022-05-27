import getCustomers from "../utils/getCustomers.js";
import { textInput,Button } from "../utils/InputFields.js";


export const CustomerSearchBox = ( data ) => {

  const res = Object.values(data).map( v => `<a class="cust-row" data-cust_id ="${v.cust_id}" href="javascript:void(0);">${v.fullname}</a>`).join(' ')


  const output = `
  <div class="form-group">
  <input type="text" placeholder="Search Customers" autocomplete="off"  class="cust-search-inpt form-control" id="cust-search-inpt">
  </div>

  <div class="cust-search-res-wrapper">

  <div class="cust-search-res-header">
    <div class="cust-search-add-button">
       <a href="javascript:void(0);"  data-toggle="modal" data-target="#customerModal">ADD NEW CUSTOMER</a>
    </div>
    <div>
      <a href="javascript:void(0);" class="cust-search-close-button">Close</a>
    </div>
  </div>

  <div class="cust-search-res-body">

    ${res}

  </div>

  </div>

  <input type="hidden" class="cust_id" >

	<!--===================================
	BEGIN ADD CUSTOMER MODAL BOX 
	===================================--->
	<div id="customerModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-l">
        <div class="modal-content  p-4">
		<div class="p-2 shadow">
		<!------------------------
		Begin Modal Button
		------------------------->
        <div class="modal-header bg-light">
        <h5 class="h2" id="title">NEW CUSTOMER</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		</div>	
		<!------------------------
		End Modal Button
		------------------------->
	    <br>
		<form>	
        <div class="modal-body">
		<div class="row">

		<div class="col-md-6">
			${
				textInput({
					type: 'text',
					classname: 'fullname',
					required: true,
					label: 'Fullname'
				})
			}

			${
				textInput({
					type: 'text',
					classname: 'phone',
					required: false,
					label: 'Phone (Optional)'
				})
			}
		</div>



		<div class="col-md-6">

		${
			textInput({
				type: 'email',
				classname: 'email',
				required: false,
				label: 'Email (Optional)'
			})
		}

		${
			textInput({
				type: 'text',
				classname: 'location',
				required: true,
				label: 'Location'
			})
		}

		</div>
		</div>
		</div>


		<div class="modal-footerd">
			${
				Button({
					output: 'output1',
					classname: 'saveCustomer',
					buttonname: 'SAVE'
				})
			}
        </div>

		</form>
		</div>
        </div>
        </div>
        </div>		
        </div>
	<!--===================================
	END ADD CUSTOMER MODAL BOX 
	===================================--->

  `;

  document.querySelector(".customers").innerHTML = output;
};


export const searchCustomers = ( val )=>{
  getCustomers((data)=>{
    const res = Object.values(data).filter( v => Object.values(v).join(' ').toLowerCase().includes( val.toLowerCase()))
    .map( v => `<a class="cust-row" data-cust_id ="${v.cust_id}" href="javascript:void(0);">${v.fullname}</a>`).join(' ')
    document.querySelector('.cust-search-res-body').innerHTML = res
  })
}
