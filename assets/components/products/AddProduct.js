

    const AddProduct = () => {

        return ` 
            <a href="" class="btn btn-default btn-sm rounded-lg" data-toggle="modal" data-target="#addproduct">Add Product</a>

            <div id="addproduct" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-l">
                    <div class="modal-content  p-4">
                        <div class="p-2 shadow">
                        <div class="modal-header bg-light">
                            <h5 class="h2" id="title">New Product</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div id="presult"></div>
                        
                        <div class="row">
                        <div class="col-sm-12 col-md-6">

                        <div class="form-group has-feedback inputBox">
                            <input type="text" autocomplete="off" id="datex" class="search form-control date calendar"  required>
                            <label>Date:</label>	
                            <div id="custom-pos"></div>
                        </div>	 

                        <div class="form-group  inputBox  pt-0">		  
                            <input type="text" class="form-control search" id="prod_name"  required>
                            <label for="fullname">Product Name</label>
                        </div>

                        <div class="form-group  inputBox  pt-0">		  
                            <input type="text" class="form-control search" id="selling_price"  required>
                            <label for="fullname">Product Price</label>
                        </div>

                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group  inputBox  pt-0">		  
                                <select style="font-size: 12px;" class="categoryx search form-control" id="cat_id" >
            
                                </select>
                            </div>
                            <ul id="items-lists" style="font-size: 12px;"></ul>


                        <div class="form-group  inputBox  pt-0">		  
                            <input type="number" class="form-control search" id="prod_qty"  required>
                            <label for="prod_qty">Quantity</label>
                        </div>

                        <div class="form-group  inputBox  pt-0">		  
                            <select id="package" class="form-control search" style="font-size: 12px;">
                                <option hidden>Select package</option>
                                <option>Pcs</option>
                                <option>Boxes</option>
                                <option>Bags</option>
                                <option>Other</option>
                            </select>
                        </div>


                        </div>
                        </div>
                        </div>     
                        <div class="modal-footer">
                        <a href="javascript:void(0);" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</a>
                        <a href="javascript:void(0);" id="button" class="btn btn-default btn-sm 
                        AddProduct">Add Product</a>
                        </div>
                        </form>
      
                    </div>
                </div>		
            </div>
        `
    }

    export default AddProduct
