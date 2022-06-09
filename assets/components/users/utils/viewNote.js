// viewNote(
//     e,
//     getUsers,
//     classSelector,
//     clearNoteFields
// ) 


const viewNote = (
    e,
    getUsers,
    classSelector,
    clearNoteFields
) => {
   //On click display and edit a user
   document.body.style.overflow = 'hidden'
   classSelector('modal-wrapper3').classList.add('show')

   getUsers((data) => {

       const id  = e.target.dataset.id

       const notes = Object.values(data).map( v => v.note.map(v => ({
           note_id: v.note_id,
           id: v.id,
           message: v.message,
           date: v.date
       }))).flat(Infinity)
   
       const v = notes.filter( v => v.note_id === id )[0]

       clearNoteFields(classSelector)

       //Populate user input field 
       classSelector('vnotemessage').value = v.message
       classSelector('vnotedate').valueAsDate =  new Date(v.date)
   })

}

export default viewNote