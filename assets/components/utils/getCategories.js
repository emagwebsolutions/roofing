const getCategories = async (callback)=>{
   const resp = await fetch('router.php?controller=products&task=categories');
   const data = await resp.json();
   const cat = Object.values(data).map( v => `<option value="${v.cat_id}">${v.cat_name}</option>`).join('');
   return callback(cat)
}

export default getCategories