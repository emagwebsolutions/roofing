

// editNote(
//     e,
//     getUsers,
//     classSelector,
//     clearNoteFields 
// )

const editNote = (
e,
getUsers,
classSelector,
clearNoteFields 
) => {


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
          classSelector('noteid').value =  v.note_id
          classSelector('notemessage').value = v.message
          classSelector('notedate').valueAsDate =  new Date(v.date)
      })

}

export default editNote