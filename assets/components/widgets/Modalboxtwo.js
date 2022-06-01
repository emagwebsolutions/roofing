

document.addEventListener('click', e => {
    if(e.target.matches('.close-modal2')){
        const par = e.target.parentElement.parentElement.parentElement
        par.classList.remove('show')
        document.body.style.overflow = 'scroll'
    }
})

window.addEventListener('click', e => {
    if(e.target.matches('.modal-wrapper2')){
        e.target.classList.remove('show')
        document.body.style.overflow = 'scroll'
    }
})

const Modalboxtwo = ( title = '', btnclass = '', body='BODY AREA' ) => (
    `
    <div class="modal-wrapper2">
    
        <div class="modal-inner">
            <div class="modal-top">
                <h1 class="modal-heading">${ title }</h1> 
                <a href="javascript:void(0);" class="close-modal2">&times;</a>
            </div>
            <div class="modal-body">
                ${body}
            </div>
            <div class="modal-footer">
                <button class="modal-btn ${btnclass}">SAVE</button>
            </div>
        </div>
    </div>
    `
)

export default Modalboxtwo