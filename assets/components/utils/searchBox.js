
const searchBox = (c,p) => {
    return `
    <div class="form-group  pt-0 input-animate">	
    <input type="text"  placeholder=" " class="fminpt form-control ${c}" required="true" readonly>
    <label>${p}</label>
    </div>
    `
}

export default searchBox;