

document.addEventListener('click', e => {
    if(e.target.matches('.close-modal')){
        const par = e.target.parentElement.parentElement.parentElement
        par.classList.remove('show')
        document.body.style.overflow = 'scroll'
    }
})

window.addEventListener('click', e => {
    if(e.target.matches('.modal-wrapper')){
        e.target.classList.remove('show')
        document.body.style.overflow = 'scroll'
    }
})

const Modalbox = ( title = '', btnclass = '', body='BODY AREA' ) => (
    `
    <div class="modal-wrapper">
    
        <div class="modal-inner">
            <div class="modal-top">
                <h1 class="modal-heading">${ title }</h1> 
                <a href="javascript:void(0);" class="close-modal">&times;</a>
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

export default Modalbox