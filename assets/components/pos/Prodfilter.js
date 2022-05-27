import StocksCallback from "../utils/StocksCallback.js";

export const productFilteroutput = (categories, products) => {
  const output = `
    <div class="form-group">
    <input type="search" class="form-control filter-prods" placeholder="Search product" />
    </div>
    <div class="prod-filter-wrapper">
        <div class="prod-filter-top">
        <div>
        <a href="javascript:void(0)" class="prod-filter-top-btn" title="Add new row">Add new row</a>
        </div>
        <div class="prod-filter-top-dropdown"> 
        
        <div class="form-group">
        <input type="search" class="form-control cat-search" placeholder="Search category" /> 
        </div>
            <ul class="cat-list-wrapper">
            <li>
            <a href="javascript:void(0);" class="close-cat-box">Close</a>
            </li>
            <li>
            <ul class="cat-list">
            ${categories}
            </ul>
            </li>
            </ul>
        </div> 
        </div>
        <div class="prod-filter-bottom">
        <table  class="prod-search">
        <a href="javascript:void(0);" class="close-prod-box">Close</a>
        ${products}
        </table>
         </div>
    </div>`;
  return output;
};

export const getAllProducts = () => {
  StocksCallback((data) => {
    const allproducts = Object.values(data)
      .map((v) => {
        if (v.remaining) {
          return `<tr class="prod-filter-row">
                        <td>
                            <a href="javascript:void(0);" data-prod_qty="${v.prod_qty}" data-prod_name="${v.prod_name}" data-unit_price="${v.selling_price}" class="prodfilter-link">${v.prod_name}</a>
                        </td>
                        <td>
                            ${v.remaining}
                        </td>
                        </tr>
                `;
        }
      })
      .join(" ");
    const catArrs = Object.values(data).map((v) => {
      return { cat_name: v.cat_name };
    });
    const groupCatArrs = [
      ...new Map(catArrs.map((v) => [v.cat_name, v])).values(),
    ];
    const categories = Object.values(groupCatArrs)
      .map((v) => `<li><span class="cat-link">${v.cat_name}</span></li>`)
      .join(" ");
    document.querySelector(".filter-items").innerHTML = productFilteroutput(
      categories,
      allproducts
    );
  });
};

export const searchProds = (val) => {
  StocksCallback((data) => {
    if (!val)
      return (document.querySelector(".prod-filter-wrapper").style.display =
        "none");
    const searchprod = Object.values(data)
      .filter((v) =>
        Object.values(v)
          .join(" ")
          .toLocaleLowerCase()
          .includes(val.toLocaleLowerCase())
      )
      .map((v) => {
        if (v.remaining) {
          return `<tr class="prod-filter-row">
                        <td>
                            <a href="javascript:void(0);" data-prod_name="${v.prod_name}" data-unit_price="${v.selling_price}"  class="prodfilter-link">${v.prod_name}</a>
                        </td>
                        <td>
                            ${v.remaining}
                        </td>
                        </tr>`;
        }
      })
      .join(" ");
    document.querySelector(".prod-search").innerHTML = searchprod;
  });
};

export const searchCategory = (val) => {
  StocksCallback((data) => {
    if (!val)
      return (document.querySelector(".cat-list-wrapper").style.display =
        "none");
    const catArrs = Object.values(data).map((v) => {
      return { cat_name: v.cat_name };
    });
    const groupCatArrs = [
      ...new Map(catArrs.map((v) => [v.cat_name, v])).values(),
    ];
    const searchresp = Object.values(groupCatArrs)
      .filter((v) =>
        Object.values(v).join(" ").toLowerCase().includes(val.toLowerCase())
      )
      .map((v) => `<li><span class="cat-link">${v.cat_name}</span></li>`)
      .join(" ");

    document.querySelector(".cat-list").innerHTML = searchresp;
  });
};
