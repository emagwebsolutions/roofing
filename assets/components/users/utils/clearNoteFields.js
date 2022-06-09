
// clearNoteFields(classSelector)

const clearNoteFields = (classSelector) => {
    classSelector('noteid').value =  null
    classSelector('notemessage').value = null
    classSelector('notedate').valueAsDate = null
}

export default clearNoteFields