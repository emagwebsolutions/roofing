const clearFormFields = () => {
    Array.from(document.querySelectorAll('[type="text"]')).forEach( v => v.value = null )
    Array.from(document.querySelectorAll('[type="email"]')).forEach( v => v.value = null )
    Array.from(document.querySelectorAll('[type="date"]')).forEach( v => v.value = null )
    Array.from(document.querySelectorAll('[type="hidden"]')).forEach( v => v.value = null )
    Array.from(document.querySelectorAll('[type="checkbox"]')).forEach( v => v.checked = false )
}

export default clearFormFields