
import Categories from '../utils/Categories.js'
import { getProducts } from './logic/useProducts.js'
import AddProduct from './AddProduct.js'
import searchBox from '../utils/searchBox.js'


const Products = ()=>{

    getProducts();

    return `
        <section class="p-4">
        <div class="container-fluid bg-white">
        <div class="row">
        <div class="col-sm-12 col-md-3">
            ${Categories()}
        </div>
        <div class="col-sm-12 col-md-9">
        <div class="row">
            <div class="col-sm-12 col-md-2">
                ${AddProduct()}
            </div>
            <div class="col-sm-12 col-md-4">
            ${searchBox('searchprod','Search Products')}
            </div>
            <div class="col-sm-12 col-md-2 text-center" id="genresult">
                <a href="javascript:void(0);" class="btn btn-danger btn-sm rounded-lg prodpdf">View Products</a>
                <span id="checkabox"></span>
            </div>
            <div class="col-sm-12 col-md-2">
                <p class="lead text-uppercase font-weight-bold"  id="stockname">Products</p>
            </div>
        </div>

        <div  class="grid-striped">
            <div id="productsScroll">
                <div class="row   table-header" id="ttt"> 

                    <div class="col-sm-12 col-md-1">
                        <div class="custom-control custom-checkbox" style="margin-top: -14px;">
                            <br>
                            <input type="checkbox" class="custom-control-input checkall" id="diziza">
                            <label class="custom-control-label badge badge-success" for="diziza">#</label>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">Product Name</div>
                    <div class="col-sm-12 col-md-1">Price (<span id="curr"></span>)</div>
                    <div class="col-sm-12 col-md-1">Qty</div>
                    <div class="col-sm-12 col-md-1">Sold</div>
                    <div class="col-sm-12 col-md-1">Remaining</div>
                    <div class="col-sm-12 col-md-2">Updated on</div>
                    <div class="col-sm-12 col-md-1">Action</div>

                </div>

                <div id="products"></div>

            </div>
        </div>

        </div>
        </div>
        </div>
        </section>


        <div id="editproduct" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-l">
            <div class="modal-content  p-4">
                <div class="p-2 shadow">
                <div class="modal-header bg-light">
                    <h5 class="h2" id="title">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div id="upresult"></div>
                
                <div class="row">
                <div class="col-sm-12 col-md-6">

                <div class="form-group has-feedback inputBox">
                    <input type="text" autocomplete="off" id="udate" class="search form-control date calendar2"  required>
                    <label>Date:</label>	
                    <div id="custom-pos2"></div>
                </div>	 

                <div class="form-group  inputBox  pt-0">		  
                    <input type="text" class="form-control search" id="uprod_name"  required>
                    <label for="fullname">Product Name</label>
                </div>

                <div class="form-group  inputBox  pt-0">		  
                    <input type="text" class="form-control search" id="uselling_price"  required>
                    <label for="fullname">Product Price</label>
                </div>

                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-group  inputBox  pt-0">		  
                        <select style="font-size: 12px;" class="categoryx search form-control ucat_id" id="ucat_id" >
    
                        </select>
                    </div>
                    <ul id="items-lists" style="font-size: 12px;"></ul>


                <div class="form-group  inputBox  pt-0">		  
                    <input type="number" class="form-control search" id="uprod_qty"  required>
                    <label for="prod_qty">Quantity</label>
                </div>

                <div class="form-group  inputBox  pt-0">		  
                    <select id="upackage" class="form-control search" style="font-size: 12px;">
                        <option>Pcs</option>
                        <option>Boxes</option>
                        <option>Bags</option>
                        <option>Other</option>
                    </select>
                </div>

                <input type="hidden" id="prod_id" >

                </div>
                </div>
                </div>     
                <div class="modal-footer">
                <a href="javascript:void(0);" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</a>
                <a href="javascript:void(0);" id="button" class="btn btn-default btn-sm 
                EditProduct">Update Productss</a>
                </div>
                </form>

            </div>
        </div>		
    </div>

    `
}

export default Products;
