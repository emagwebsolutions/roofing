
import Stocks from "../Stocks.js";

const StocksCallback = async ( callback )=>{
	//PRODUCTS
	const resp = await fetch('router.php?controller=products&task=all_products');
	const data = await resp.json();
	const products = Array.from(data);
	
	// //SALES
	const sales = await fetch('router.php?controller=products&task=get_sales');
	const sdata = await sales.json();
	const sale = sdata;
	const stk = Stocks(products,sale);



	return callback(stk)
}
export default StocksCallback